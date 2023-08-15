<?php

namespace App\Http\Controllers;

use App\Models\Advocate;
use App\Models\Bill;
use App\Models\Cases;
use App\Models\PointOfContacts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AdvocateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('manage advocate')){
            $advocates = Advocate::where('created_by',Auth::user()->creatorId())->get();
            return view('advocate.index',compact('advocates'));
        }else{
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

        if(Auth::user()->can('create advocate')){
            return view('advocate.create');

        }else{
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
        if(Auth::user()->can('create advocate')){

            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|digits:10',
                    'age' => 'required|numeric',
                    'father_name' => 'required',
                    'company_name' => 'required|max:120',
                    'website' => 'required',
                    'tin' => 'required',
                    'gstin' => 'required|min:15',
                    'pan_number' => 'required|min:10',
                    'hourly_rate' => 'required|numeric',
                    'ofc_address_line_1' => 'required',
                    'ofc_address_line_2' => 'required',
                    'ofc_country' => 'required',
                    'ofc_state' => 'required',
                    'ofc_city' => 'required',
                    'ofc_zip_code' => 'required|numeric',
                    'home_address_line_1' => 'required',
                    'home_address_line_2' => 'required',
                    'home_country' => 'required',
                    'home_state' => 'required',
                    'home_city' => 'required',
                    'home_zip_code' => 'required',
                ]
            );
            foreach ($request->point_of_contacts as $items) {
                foreach ($items as $item) {

                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your contacts');

                        return $msg;
                    }

                }
                $validator = \Validator::make(
                    $items, [
                        'contact_name' => 'required',
                        'contact_email' => 'required',
                        'contact_phone' => 'required|numeric|digits:10',
                        'contact_designation' => 'required',
                    ]
                );

            }

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user = Auth::user();
            $plan = $user->getPlan();
            $total_user = Advocate::where('created_by',$user->creatorId())->count();

            if ($total_user < $plan->max_advocates || $plan->max_advocates == -1) {
                $advocate = new Advocate();
                $advocate['name']                 = $request->name;
                $advocate['email']                = $request->email;
                $advocate['phone_number']         = $request->phone_number;
                $advocate['father_name']          = $request->father_name;
                $advocate['age']                  = $request->age;
                $advocate['company_name']         = $request->company_name;
                $advocate['website']              = $request->website;
                $advocate['tin']                  = $request->tin;
                $advocate['gstin']                = $request->gstin;
                $advocate['pan_number']           = $request->pan_number;
                $advocate['hourly_rate']          = $request->hourly_rate;
                $advocate['ofc_address_line_1']   = $request->ofc_address_line_1;
                $advocate['ofc_address_line_2']   = $request->name;
                $advocate['ofc_country']          = $request->ofc_country;
                $advocate['ofc_state']            = $request->ofc_state;
                $advocate['ofc_city']             = $request->ofc_city;
                $advocate['ofc_zip_code']         = $request->ofc_zip_code;
                $advocate['home_address_line_1']  = $request->home_address_line_1;
                $advocate['home_address_line_2']  = $request->home_address_line_2;
                $advocate['home_country']         = $request->home_country;
                $advocate['home_state']           = $request->home_state;
                $advocate['home_city']            = $request->home_city;
                $advocate['home_zip_code']        = $request->home_zip_code;
                $advocate['created_by']        = Auth::user()->creatorId();
                $advocate->save();

                foreach ($request->point_of_contacts as $key => $value) {
                    $contacts = new PointOfContacts();

                    $contacts['advocate_id'] = $advocate->id;
                    $contacts['contact_name'] = $value['contact_name'];
                    $contacts['contact_email'] = $value['contact_email'];
                    $contacts['contact_phone'] = $value['contact_phone'];
                    $contacts['contact_designation'] = $value['contact_designation'];

                    $contacts->save();
                }

                return redirect()->route('advocate.index')->with('success', __('Advocate successfully created.'));
            }else{

                return redirect()->route('advocate.index')->with('error', __('Your user limit is over, Please upgrade plan.'));
            }
        }else{
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
        if (Auth::user()->can('view advocate')) {

            $cases = [];
            $cases_data = Cases::get();
            foreach($cases_data as $key => $case){
                if(str_contains($case->your_advocates, $id)){
                    $cases[$key]['id'] = $case->id;
                    $cases[$key]['court'] = $case->court;
                    $cases[$key]['highcourt'] = $case->highcourt;
                    $cases[$key]['casenumber'] = $case->casenumber;
                    $cases[$key]['bench'] = $case->bench;
                    $cases[$key]['diarybumber'] = $case->diarybumber;
                    $cases[$key]['title'] = $case->title;
                    $cases[$key]['your_advocates'] = $case->your_advocates;
                    $cases[$key]['hearing_date'] = $case->hearing_date;
                    $cases[$key]['priority'] = $case->priority;
                    $cases[$key]['year'] = $case->year;
                }
            }

            return view('advocate.view',compact('cases'));

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
        if (Auth::user()->can('edit advocate')) {

            $advocate = Advocate::find($id);
            if($advocate){

                $contacts = PointOfContacts::where('advocate_id',$advocate->id)->get();
                return view('advocate.edit',compact('advocate','contacts'));
            }else{

                return redirect()->back()->with('error', __('Advocate not found.'));
            }

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
        if (Auth::user()->can('edit advocate')) {

            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required|max:120',
                    'email' => 'required|email',
                    'phone_number' => 'required|numeric|digits:10',
                    'age' => 'required|numeric',
                    'father_name' => 'required',
                    'company_name' => 'required|max:120',
                    'website' => 'required',
                    'tin' => 'required',
                    'gstin' => 'required|min:15',
                    'pan_number' => 'required|min:10',
                    'hourly_rate' => 'required|numeric',
                    'ofc_address_line_1' => 'required',
                    'ofc_address_line_2' => 'required',
                    'ofc_country' => 'required',
                    'ofc_state' => 'required',
                    'ofc_city' => 'required',
                    'ofc_zip_code' => 'required|numeric',
                    'home_address_line_1' => 'required',
                    'home_address_line_2' => 'required',
                    'home_country' => 'required',
                    'home_state' => 'required',
                    'home_city' => 'required',
                    'home_zip_code' => 'required',
                    ]
            );
            foreach ($request->point_of_contacts as $items) {
                foreach ($items as $item) {

                    if (empty($item) && $item < 0) {
                        $msg['flag'] = 'error';
                        $msg['msg'] = __('Please enter your contacts');

                        return $msg;
                    }

                }
                $validator = \Validator::make(
                    $items, [
                        'contact_name' => 'required',
                        'contact_email' => 'required',
                        'contact_phone' => 'required|numeric|digits:10',
                        'contact_designation' => 'required',
                    ]
                );

            }

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $advocate = Advocate::find($id);
            $advocate['name'] = $request->name;
            $advocate['email'] = $request->email;
            $advocate['phone_number'] = $request->phone_number;
            $advocate['father_name'] = $request->father_name;
            $advocate['age'] = $request->age;
            $advocate['company_name'] = $request->company_name;
            $advocate['website'] = $request->website;
            $advocate['tin'] = $request->tin;
            $advocate['gstin'] = $request->gstin;
            $advocate['pan_number'] = $request->pan_number;
            $advocate['hourly_rate'] = $request->hourly_rate;
            $advocate['ofc_address_line_1'] = $request->ofc_address_line_1;
            $advocate['ofc_address_line_2'] = $request->name;
            $advocate['ofc_country'] = $request->ofc_country;
            $advocate['ofc_state'] = $request->ofc_state;
            $advocate['ofc_city'] = $request->ofc_city;
            $advocate['ofc_zip_code'] = $request->ofc_zip_code;
            $advocate['home_address_line_1'] = $request->home_address_line_1;
            $advocate['home_address_line_2'] = $request->home_address_line_2;
            $advocate['home_country'] = $request->home_country;
            $advocate['home_state'] = $request->home_state;
            $advocate['home_city'] = $request->home_city;
            $advocate['home_zip_code'] = $request->home_zip_code;
            $advocate->save();

            foreach (json_decode($request->old_contacts,true) as $key => $value) {
                $contacts = PointOfContacts::find($value['id']);
                $contacts->delete();
            }

            foreach ($request->point_of_contacts as $key => $value) {
                $contacts = new PointOfContacts();

                $contacts['advocate_id'] = $advocate->id;
                $contacts['contact_name'] = $value['contact_name'];
                $contacts['contact_email'] = $value['contact_email'];
                $contacts['contact_phone'] = $value['contact_phone'];
                $contacts['contact_designation'] = $value['contact_designation'];

                $contacts->save();
            }

            return redirect()->route('advocate.index')->with('success', __('Advocate successfully updated.'));



        }else{
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
        if (Auth::user()->can('delete advocate')) {
            try {
                $cases = Cases::where('your_advocates',$id)->get();
                
                if (count($cases) > 0) {
                    return redirect()->route('advocate.index')->with('error', __('This advocate is assigned to case.'));
                }else{

                    Advocate::find($id)->delete();

                    PointOfContacts::where('advocate_id', $id)->delete();
                    return redirect()->route('advocate.index')->with('success', __('Advocate successfully deleted.'));

                }

            } catch (Throwable $th) {

                return redirect()->back()->with('error', $th);
            }



        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }

    public function contacts($id){
        if(Auth::user()->can('view advocate')){
            $contacts = PointOfContacts::where('advocate_id',$id)->get();
            return view('advocate.contacts',compact('contacts'));
        }else{
            return redirect()->back()->with('error', __('Permission Denied.'));

        }
    }

    public function bills($id){
        if(Auth::user()->can('view advocate')){
            $bills = Bill::where('advocate',$id)->get();
            return view('advocate.bills',compact('bills'));
        }else{
            return redirect()->back()->with('error', __('Permission Denied.'));

        }
    }

       public function view($id){
        if(Auth::user()->can('view advocate')){
            $advocate = Advocate::find($id);
            return view('advocate.detail',compact('advocate'));
        }else{
            return redirect()->back()->with('error', __('Permission Denied.'));

        }
    }
}
