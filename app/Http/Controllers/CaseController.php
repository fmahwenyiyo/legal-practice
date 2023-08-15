<?php

namespace App\Http\Controllers;

use App\Models\Advocate;
use App\Models\Cases;
use App\Models\Court;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('manage case')) {
            $cases = Cases::where('created_by',Auth::user()->creatorId())->get();

            return view('cases.index', compact('cases'));

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
        if (Auth::user()->can('create case')) {
            $courts = Court::where('created_by',Auth::user()->creatorId())->pluck('name', 'id')->prepend('Please Select', '');
            $advocates = Advocate::where('created_by',Auth::user()->creatorId())->pluck('name', 'id');
            $team = User::where('created_by',Auth::user()->creatorId())->pluck('name', 'id');

            return view('cases.create', compact('courts', 'advocates', 'team'));

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
        if (Auth::user()->can('create case')) {
            $validator = Validator::make(
                $request->all(), [
                    'court' => 'required',
                    'year' => 'required',
                    'filing_date' => 'required',
                    'court_hall' => 'required|numeric',
                    'floor' => 'required|numeric',
                    'title' => 'required',
                    'description' => 'required',
                    'before_judges' => 'required',
                    'referred_by' => 'required',
                    'section' => 'required',
                    'priority' => 'required',
                    'under_acts' => 'required',
                    'under_sections' => 'required',
                    'FIR_police_station' => 'required',
                    'FIR_number' => 'required',
                    'FIR_year' => 'required',
                    'your_advocates' => 'required',
                    'hearing_date' => 'required',
                    'stage' => 'required',
                    'session' => 'required',
                ]
            );
            foreach ($request->opponents as $items) {
                foreach ($items as $item) {
                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your opponents');

                        return redirect()->back()->with('error', $msg['msg']);
                    }

                }
                $validator = Validator::make(
                    $items, [
                        'opponents_name' => 'required',
                        'opponents_email' => 'required',
                        'opponents_phone' => 'required|numeric|digits:10',
                    ]
                );

            }

            foreach ($request->opponent_advocates as $items) {
                foreach ($items as $item) {
                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your opponent advocates');

                        return redirect()->back()->with('error', $msg['msg']);
                    }

                }
                $validator = Validator::make(
                    $items, [
                        'opp_advocates_name' => 'required',
                        'opp_advocates_email' => 'required',
                        'opp_advocates_phone' => 'required|numeric|digits:10',
                    ]
                );

            }

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $case = new Cases();
            $case['court'] = $request->court;
            $case['highcourt'] = $request->highcourt;
            $case['bench'] = $request->bench;
            $case['casetype'] = $request->casetype;
            $case['casenumber'] = $request->casenumber;
            $case['diarybumber'] = !empty($request->diarybumber) ? $request->diarybumber : null;
            $case['year'] = $request->year;
            $case['case_number'] = $request->case_number;
            $case['filing_date'] = $request->filing_date;
            $case['court_hall'] = $request->court_hall;
            $case['floor'] = $request->floor;
            $case['title'] = $request->title;
            $case['description'] = $request->description;
            $case['before_judges'] = $request->before_judges;
            $case['referred_by'] = $request->referred_by;
            $case['section'] = $request->section;
            $case['priority'] = $request->priority;
            $case['under_acts'] = $request->under_acts;
            $case['under_sections'] = $request->under_sections;
            $case['FIR_police_station'] = $request->FIR_police_station;
            $case['FIR_number'] = $request->FIR_number;
            $case['FIR_year'] = $request->FIR_year;
            $case['hearing_date'] = $request->hearing_date;
            $case['stage'] = $request->stage;
            $case['session'] = $request->session;
            $case['your_advocates'] = implode(',', $request->your_advocates);
            $case['your_team'] = implode(',', $request->your_team);
            $case['opponents'] = json_encode($request->opponents);
            $case['opponent_advocates'] = json_encode($request->opponent_advocates);
            $case['created_by'] = Auth::user()->creatorId();
            $case->save();

            if ($request->get('is_check') == '1') {
                $type = 'appointment';
                $request1 = new Cases();
                $request1->title = $request->title;
                $request1->start_date = $request->hearing_date;
                $request1->end_date = $request->hearing_date;
                Utility::addCalendarData($request1, $type);
            }

            return redirect()->route('cases.index')->with('success', __('Case successfully created.'));

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
    public function show($id)
    {
        if (Auth::user()->can('view case')) {

            $case = Cases::find($id);
            return view('cases.view',compact('case'));

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
        if (Auth::user()->can('edit case')) {
            $courts = Court::where('created_by',Auth::user()->creatorId())->pluck('name', 'id')->prepend('Please Select', '');
            $advocates = Advocate::where('created_by',Auth::user()->creatorId())->pluck('name', 'id');
            $team = User::where('created_by',Auth::user()->creatorId())->pluck('name', 'id');
            $case = Cases::find($id);
            $your_advocates = Advocate::where('created_by',Auth::user()->creatorId())->whereIn('id', explode(',', $case->your_advocates))->get();
            $your_team = User::where('created_by',Auth::user()->creatorId())->whereIn('id', explode(',', $case->your_team))->get();
            $priorities = ['Super Critical' => 'Super Critical', 'Critical' => 'Critical', 'Important' => 'Important', 'Routine' => 'Routine', 'Normal' => 'Normal'];

            $case_typ = Cases::caseType();
            return view('cases.edit', compact('courts', 'advocates', 'team', 'case', 'your_advocates', 'your_team', 'priorities','case_typ'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }


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
        if (Auth::user()->can('edit case')) {

            $validator = Validator::make(
                $request->all(), [
                    'court' => 'required',
                    'year' => 'required',
                    'filing_date' => 'required',
                    'court_hall' => 'required|numeric',
                    'floor' => 'required|numeric',
                    'title' => 'required',
                    'description' => 'required',
                    'before_judges' => 'required',
                    'referred_by' => 'required',
                    'section' => 'required',
                    'priority' => 'required',
                    'under_acts' => 'required',
                    'under_sections' => 'required',
                    'FIR_police_station' => 'required',
                    'FIR_number' => 'required',
                    'FIR_year' => 'required',
                    'hearing_date' => 'required',
                    'stage' => 'required',
                    'session' => 'required',

                ]
            );

            foreach ($request->opponents as $items) {
                foreach ($items as $item) {
                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your opponents');

                        return redirect()->back()->with('error', $msg['msg']);

                    }

                }
                $validator = Validator::make(
                    $items, [
                        'opponents_name' => 'required',
                        'opponents_email' => 'required',
                        'opponents_phone' => 'required|numeric|digits:10',
                    ]
                );

            }

            foreach ($request->opponent_advocates as $items) {
                foreach ($items as $item) {
                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your opponent advocates');

                        return redirect()->back()->with('error', $msg['msg']);

                    }

                }
                $validator = Validator::make(
                    $items, [
                        'opp_advocates_name' => 'required',
                        'opp_advocates_email' => 'required',
                        'opp_advocates_phone' => 'required|numeric|digits:10',
                    ]
                );

            }

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $case = Cases::find($id);
            $case['court'] = $request->court;
            $case['highcourt'] = $request->highcourt;
            $case['bench'] = $request->bench;
            $case['casetype'] = $request->casetype;
            $case['casenumber'] = $request->casenumber;
            $case['diarybumber'] = !empty($request->diarybumber) ? $request->diarybumber : null;
            $case['year'] = $request->year;
            $case['case_number'] = $request->case_number;
            $case['filing_date'] = $request->filing_date;
            $case['court_hall'] = $request->court_hall;
            $case['floor'] = $request->floor;
            $case['title'] = $request->title;
            $case['description'] = $request->description;
            $case['before_judges'] = $request->before_judges;
            $case['referred_by'] = $request->referred_by;
            $case['section'] = $request->section;
            $case['priority'] = $request->priority;
            $case['under_acts'] = $request->under_acts;
            $case['under_sections'] = $request->under_sections;
            $case['FIR_police_station'] = $request->FIR_police_station;
            $case['FIR_number'] = $request->FIR_number;
            $case['FIR_year'] = $request->FIR_year;
            $case['hearing_date'] = $request->hearing_date;
            $case['stage'] = $request->stage;
            $case['session'] = $request->session;
            $case['your_advocates'] = implode(',', $request->your_advocates);
            $case['your_team'] = implode(',', $request->your_team);
            $case['opponents'] = json_encode($request->opponents);
            $case['opponent_advocates'] = json_encode($request->opponent_advocates);
            $case->save();

            return redirect()->route('cases.index')->with('success', __('Case successfully updated.'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
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
        if (Auth::user()->can('delete case')) {

            $case = Cases::find($id);
            $case->delete();

            return redirect()->route('cases.index')->with('success', __('Case successfully deleted.'));


        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }
}
