<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'plan',
        'lang',
        'avatar',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function creatorId()
    {
        if ($this->type == 'company' || $this->type == 'super admin') {
            return $this->id;
        } else {
            return $this->created_by;
        }

    }

    public static function getTeams($id)
    {
        $advName = User::whereIn('id', explode(',', $id))->pluck('name')->toArray();
        return implode(', ', $advName);
    }

    public static function getUser($id)
    {
        $advName = User::find($id);
        return $advName;
    }
    public function currentLanguage()
    {
        return $this->lang;
    }

    public function invoiceNumberFormat($number)
    {
        $settings = Utility::settings();

        return '#' . sprintf("%05d", $number);
    }

    public static function dateFormat($date)
    {
        $settings = Utility::settings();
        return date($settings['site_date_format'], strtotime($date));
    }

    public function assignPlan($planID)
    {
        $plan = Plan::find($planID);
        if ($plan) {
            $this->plan = $plan->id;
            if ($plan->duration == 'month') {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($plan->duration == 'year') {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $this->plan_expire_date = null;
            }
            $this->save();

            $users = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', '!=', 'employee')->get();
            $employees = User::where('created_by', '=', \Auth::user()->creatorId())->where('type', 'employee')->get();

            $userCount = 0;
            foreach ($users as $user) {
                $userCount++;
                if ($userCount <= $plan->max_users) {
                    $user->is_active = 1;
                    $user->save();
                } else {
                    $user->is_active = 0;
                    $user->save();
                }
            }
            $employeeCount = 0;
            foreach ($employees as $employee) {
                $employeeCount++;
                if ($employeeCount <= $plan->max_employees) {
                    $employee->is_active = 1;
                    $employee->save();
                } else {
                    $employee->is_active = 0;
                    $employee->save();
                }
            }

            return ['is_success' => true];
        } else {
            return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
        }
    }

    public function countPaidCompany()
    {
        return User::where('type', '=', 'company')->whereNotIn(
            'plan', [
                      0,
                      1,
                  ]
        )->where('created_by', '=', \Auth::user()->id)->count();
    }

    public function getPlan()
    {
        $user = User::find($this->creatorId());

        return Plan::find($user->plan);
    }
}
