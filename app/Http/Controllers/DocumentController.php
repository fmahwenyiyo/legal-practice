<?php

namespace App\Http\Controllers;

use App\Models\DocType;
use App\Models\Document;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('manage document')) {
            $docs = Document::where('created_by',Auth::user()->creatorId())->get();
            return view('documents.index', compact('docs'));

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
        if (Auth::user()->can('create document')) {
            $types = DocType::where('created_by',Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('documents.create', compact('types'));

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
        if (Auth::user()->can('create document')) {

            $validator = Validator::make(
                $request->all(), [
                    'term' => 'required',
                    'type' => 'required',
                    'judgement_date' => 'required',
                    'expiry_date' => 'required',
                    'purpose' => 'required',
                    'first_party' => 'required',
                    'second_party' => 'required',
                    'headed_by' => 'required',
                    'description' => 'required',
                    'file' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $doc = new Document();
            $doc['term'] = $request->term;
            $doc['type'] = $request->type;
            $doc['judgement_date'] = $request->judgement_date;
            $doc['expiry_date'] = $request->expiry_date;
            $doc['purpose'] = $request->purpose;
            $doc['first_party'] = $request->first_party;
            $doc['second_party'] = $request->second_party;
            $doc['headed_by'] = $request->headed_by;
            $doc['description'] = $request->description;
            $doc['created_by'] = Auth::user()->creatorId();

            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStores = 'document_' . time() . '.' . $extension;

            $settings = Utility::getStorageSetting();
            if ($settings['storage_setting'] == 'local') {
                $dir = 'uploads/documents/';
            } else {
                $dir = 'uploads/documents/';
            }
            $path = Utility::upload_file($request, 'file', $fileNameToStores, $dir, []);

            if ($path['flag'] == 1) {
                $url = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }

            $filesize = number_format($request->file('file')->getSize() / 1000000, 4);
            $doc['file'] = $fileNameToStores;
            $doc['doc_size'] = $filesize;

            $doc->save();

            return redirect()->route('documents.index')->with('success', __('Document successfully created.'));

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
        if (Auth::user()->can('view document')) {
            $doc = Document::find($id);
            return view('documents.view', compact('doc'));

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
        if (Auth::user()->can('edit document')) {
            $doc = Document::find($id);
            $types = DocType::where('created_by',Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('documents.edit', compact('doc', 'types'));

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
        if (Auth::user()->can('edit document')) {

            $validator = Validator::make(
                $request->all(), [
                    'term' => 'required',
                    'type' => 'required',
                    'judgement_date' => 'required',
                    'expiry_date' => 'required',
                    'purpose' => 'required',
                    'first_party' => 'required',
                    'second_party' => 'required',
                    'headed_by' => 'required',
                    'description' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $doc = Document::find($id);
            $doc['term'] = $request->term;
            $doc['type'] = $request->type;
            $doc['judgement_date'] = $request->judgement_date;
            $doc['expiry_date'] = $request->expiry_date;
            $doc['purpose'] = $request->purpose;
            $doc['first_party'] = $request->first_party;
            $doc['second_party'] = $request->second_party;
            $doc['headed_by'] = $request->headed_by;
            $doc['description'] = $request->description;
            $doc['created_by'] = Auth::user()->id;

            if(!empty($request->file('file'))){
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileNameToStores = 'document_' . time() . '.' . $extension;

                $settings = Utility::getStorageSetting();
                if ($settings['storage_setting'] == 'local') {
                    $dir = 'uploads/documents/';
                } else {
                    $dir = 'uploads/documents/';
                }
                $path = Utility::upload_file($request, 'file', $fileNameToStores, $dir, []);

                if ($path['flag'] == 1) {
                    $url = $path['url'];
                } else {
                    return redirect()->back()->with('error', __($path['msg']));
                }

                $filesize = number_format($request->file('file')->getSize() / 1000000, 4);

                $doc['file'] = $fileNameToStores;
                $doc['doc_size'] = $filesize;
            }

            $doc->save();

            return redirect()->route('documents.index')->with('success', __('Document successfully updated.'));

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
        if (Auth::user()->can('delete document')) {
            $doc = Document::find($id);
            if ($doc) {
                $filepath = storage_path('uploads/documents/'.$doc->file);

                if (File::exists($filepath)) {
                    File::delete($filepath);
                }

                $doc->delete();
            }
            return redirect()->route('documents.index')->with('success', __('Document successfully deleted.'));


        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));

        }

    }
}
