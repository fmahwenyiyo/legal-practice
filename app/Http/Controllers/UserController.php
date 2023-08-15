<?php

namespace App\Http\Controllers;

use App\Models\group;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->can('manage member') || Auth::user()->can('manage user')) {

            $users = User::where('created_by', '=', Auth::user()->creatorId())->get();
            $user_details = UserDetail::get();

            return view('users.index', compact('users', 'user_details'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }

    public function userList()
    {

        if (Auth::user()->can('manage member') || Auth::user()->can('manage user')) {

            $users = User::where('created_by', '=', Auth::user()->creatorId())->get();
            $user_details = UserDetail::get();

            return view('users.list', compact('users', 'user_details'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create member') || Auth::user()->can('create user')) {

            $roles = Role::where('created_by', Auth::user()->creatorId())->where('id', '!=', Auth::user()->id)->get()->pluck('name', 'id');

            return view('users.create', compact('roles'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create member') || Auth::user()->can('create user')) {

            if (Auth::user()->type == 'company') {
                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|min:8',
                        'role' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $user = Auth::user();
                $plan = $user->getPlan();
                $total_user = User::where('type', '=', 'user')->where('created_by', '=', $user->creatorId())->count();

                if ($total_user < $plan->max_users || $plan->max_users == -1) {
                    $user = new User();
                    $user['name'] = $request->name;
                    $user['email'] = $request->email;
                    $user['password'] = Hash::make($request->password);
                    $user['lang'] = 'en';
                    $user['created_by'] = Auth::user()->creatorId();
                    $user['email_verified_at'] = date('Y-m-d H:i:s');


                    $role_r = Role::findById($request->role);
                    $user->assignRole($role_r);
                    $user['type'] = $role_r->name;

                    $user->save();

                    $detail = new UserDetail();
                    $detail->user_id = $user->id;
                    $detail->save();

                    return redirect()->route('users.index')->with('success', __('Member successfully created.'));
                } else {
                    return redirect()->route('users.index')->with('error', __('Your member limit is over, Please upgrade plan.'));
                }

            } else {

                $validator = Validator::make(
                    $request->all(), [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users',
                        'password' => 'required|min:8',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $user = new User();
                $user['name'] = $request->name;
                $user['email'] = $request->email;
                $user['password'] = Hash::make($request->password);
                $user['lang'] = 'en';
                $user['created_by'] = Auth::user()->creatorId();
                $user['plan'] = Plan::first()->id;

                if (Utility::settings()['email_verification'] == 'off') {
                   $user['email_verified_at'] = date('Y-m-d H:i:s');
                }

                $role_r = Role::findByName('company');
                $user->assignRole($role_r);
                $user['type'] = 'company';

                $user->save();

                $detail = new UserDetail();
                $detail->user_id = $user->id;
                $detail->save();

                return redirect()->route('users.index')->with('success', __('Member successfully created.'));

            }

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        if (Auth::user()->can('show member')) {

            $user_detail = UserDetail::where('user_id', $user_id)->first();

            if ($user_detail) {
                $data = explode(',', $user_detail->my_group);
                $my_groups = group::whereIn('id', $data)->get()->pluck('name');
                return view('users.view', compact('my_groups'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::find($id);
        $user_detail = UserDetail::where('user_id', $user->id)->first();
        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');

        return view('users.edit', compact('user', 'roles', 'user_detail'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(), [
                'name' => 'required|max:120',
                'email' => 'required|email',
            ]
        );
        if (!empty($request->mobile_number)) {

            $validator = Validator::make(
                $request->all(), [
                    'mobile_number' => 'required|numeric|digits:10',
                ]
            );
        }

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $user = User::find($id);

        if ($user) {

            $user['name'] = $request->name;
            $user['email'] = $request->email;

            if ($request->hasFile('profile')) {
                $filenameWithExt = $request->file('profile')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('profile')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $settings = Utility::Settings();
                $url = '';
                $dir = 'uploads/profile/';
                $path = Utility::upload_file($request, 'profile', $fileNameToStore, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->route('users.index', Auth::user()->id)->with('error', __($path['msg']));
                }

                $user->avatar = $fileNameToStore;
            }

            $user->update();

            $detail = UserDetail::where('user_id', $user->id)->first();

            $detail->mobile_number = !empty($request->mobile_number) ? $request->mobile_number : null;
            $detail->address = $request->address;
            $detail->city = $request->city;
            $detail->state = $request->state;
            $detail->zip_code = !empty($request->zip_code) ? $request->zip_code : null;
            $detail->landmark = $request->landmark;
            $detail->about = $request->about;

            $detail->save();

            return redirect()->route('users.index')->with('success', __('Successfully Updated!'));

        } else {
            return redirect()->back()->with('error', __('Member not found.'));

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('delete member') || Auth::user()->can('delete user')) {
            $user = User::find($id);
            $detail = UserDetail::where('user_id', $user->id)->first();

            if ($user->created_by != Auth::user()->creatorId()) {
                return redirect()->back()->with('error', __('You cant delete yourself.'));
            } else {
                if ($user && $detail) {
                    $user->delete();
                    $detail->delete();

                    $data = explode(',', $detail->my_group);
                    $my_groups = group::whereIn('id', $data)->get();

                    foreach ($my_groups as $key => $value) {
                        if (str_contains($value->members, $detail->user_id)) {
                            $value->members = trim($value->members, $detail->user_id);
                            $value->save();
                        }
                    }

                    return redirect()->back()->with('success', __('Member deleted successfully.'));
                }
            }
        } else {
            return redirect()->back()->with('error', __('Member not found.'));
        }
    }

    public function changeMemberPassword(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|confirmed|same:password_confirmation',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }



        $objUser = User::find($id);
        $objUser->password = Hash::make($request->password);
        $objUser->save();

        return redirect()->route('users.index')->with('success', __('Password updated successfully.'));

    }

    public function companyPassword($id)
    {
        $eId   = Crypt::decrypt($id);
        $user  = User::find($eId);

        $employee = User::where('id', $eId)->first();

        return view('users.reset', compact('user', 'employee'));
    }

    public function upgradePlan($user_id)
    {
        $user  = User::find($user_id);
        $plans = Plan::get();
        $admin_payment_setting = Utility::settings();
        return view('users.plan', compact('user', 'plans','admin_payment_setting'));
    }

    public function activePlan($user_id, $plan_id)
    {
        $user       = User::find($user_id);
        $user->plan = $plan_id;
        $user->save();
        $assignPlan = $user->assignPlan($plan_id);
        $plan       = Plan::find($plan_id);

        if($assignPlan['is_success'] == true && !empty($plan))
        {
            $orderID = strtoupper(str_replace('.', '', uniqid('', true)));
            Order::create(
                [
                    'order_id' => $orderID,
                    'name' => null,
                    'card_number' => null,
                    'card_exp_month' => null,
                    'card_exp_year' => null,
                    'plan_name' => $plan->name,
                    'plan_id' => $plan->id,
                    'price' => $plan->price,
                    'price_currency' => env('CURRENCY'),
                    'txn_id' => '',
                    'payment_type' => __('Manually Upgrade By Super Admin'),
                    'payment_status' => 'succeeded',
                    'receipt' => null,
                    'user_id' => $user->id,
                ]
            );
        }

        return redirect()->back()->with('success', __('Plan successfully activated.'));
    }
}
