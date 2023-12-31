<?php

namespace App\Http\Controllers;

use App\Models\Advocate;
use App\Models\Cases;
use App\Models\Document;
use App\Models\Order;
use App\Models\Plan;
use App\Models\ToDo;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            if (Auth::user()->can('show dashboard')) {

                Artisan::call('optimize:clear');

                $cases = Cases::where('created_by', Auth::user()->creatorId())->orderBy('hearing_date','ASC')->get();
                $advocate = Advocate::where('created_by', Auth::user()->creatorId())->get();
                $members = User::where('created_by', Auth::user()->creatorId())->get();
                $todos = ToDo::where('created_by', Auth::user()->creatorId())->orderBy('start_date','ASC')->get();
                $docs = Document::where('created_by', Auth::user()->creatorId())->get();


                $upcoming_case = [];
                foreach ($cases as $key => $value) {

                    if (strtotime($value->hearing_date) > strtotime(date('Y-m-d'))) {
                        $upcoming_case[$key]['title'] = $value['title'];
                        $upcoming_case[$key]['hearing_date'] = $value['hearing_date'];
                    }
                }

                $curr_time = strtotime(date("Y-m-d h:i:s"));

                // UPCOMING
                $upcoming_todo = [];
                $todayTodos = [];

                foreach ($todos as $key => $utd) {
                    $start_date = strtotime($utd->start_date);
                    if ($start_date > $curr_time && $utd->status == 1) {

                        $upcoming_todo[$key]['description'] = $utd->description;
                        $upcoming_todo[$key]['start_date'] = $utd->start_date;

                    }

                    $due = explode(' ', $utd->start_date);

                    if ($due[0] == date('Y-m-d')) {

                        $todayTodos[$key]['description'] = $utd['description'];
                        $todayTodos[$key]['start_date'] = $utd['start_date'];
                        $todayTodos[$key]['assign_to'] = $utd['assign_to'];
                        $todayTodos[$key]['assign_by'] = $utd['assign_by'];
                        $todayTodos[$key]['relate_to'] = $utd['relate_to'];
                    }

                }

                $total_diary_data = count(DiaryController::index(request())->todos) + count(DiaryController::index(request())->cases);

                $todatCases = Cases::where('created_by', Auth::user()->creatorId())->where('hearing_date', date('Y-m-d'))->get();

                return view('dashboard', compact('upcoming_case', 'cases', 'upcoming_todo', 'advocate', 'members', 'todos', 'total_diary_data', 'docs', 'todatCases', 'todayTodos'));

            } elseif (Auth::user()->can('manage super admin dashboard')) {

                $user = Auth::user();
                $user['total_user'] = User::where('type', '=', 'company')->where('created_by', Auth::user()->creatorId())->count();
                $user['total_paid_user'] = $user->countPaidCompany();
                $user['total_orders'] = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $user['total_plan'] = Plan::total_plan();
                $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->total : 0);
                $chartData = $this->getOrderChart(['duration' => 'week']);

                return view('admin_dash', compact('user', 'chartData'));
            } else {

                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            } else {
                $settings = Utility::settings();
                return redirect('login');
                
            }

        }
    }

    public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-2 week +1 day");
                for ($i = 0; $i < 14; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }

        $arrTask = [];
        $arrTask['label'] = [];
        $arrTask['data'] = [];
        foreach ($arrDuration as $date => $label) {

            $data = Order::select(DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][] = $data->total;
        }

        return $arrTask;
    }
}
