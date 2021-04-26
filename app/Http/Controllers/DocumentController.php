<?php

namespace App\Http\Controllers;

use App\MasterDocument;
use App\MasterDocumentLog;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
      /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $documents = MasterDocument::all();

        return view('pages.document.index', compact('documents'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($vendorId, $categoryId)
    {
        $doc = MasterDocument::where('category_id',$categoryId)->where('vendor_id',$vendorId)->first();

        return view('pages.document.create',compact('doc'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if($request->document_status == 1){
            $rules =  [
                'document_status' => 'required',
                'document_name' => 'required',
                'document_no' => 'required',
                'document_date' => 'required',
                'category_id' => 'required',
                'department' => 'required',
                'file' => 'required|mimes:pdf',
            ];
        }else{
            $rules =  [
                'document_status' => 'required',
            ];
        }

        $this->validate($request, $rules);

        if($request->file('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('file')->storeAs('public/document', $filenameSimpan);
        }else{
            $filenameSimpan = '';
        }

        $input = array_merge(['file' => $filenameSimpan,'created_by' => auth()->user()->id], $request->except(['file']));

        MasterDocument::create($input);
        if(isset($request->vendor_id)){
            return redirect()->route('vendor.show',$request->vendor_id)->with(['success' => 'Success Submit Document!']);

        }else{
            return redirect()->route('stockpile.show',$request->stockpile_id)->with(['success' => 'Success Submit Document!']);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $document = MasterDocument::findOrFail($id);
        return view('pages.document.create', compact('document'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if($request->document_status == 1){
            $rules =  [
                'document_status' => 'required',
                'document_name' => 'required',
                'document_no' => 'required',
                'document_date' => 'required',
                'category_id' => 'required',
                'department' => 'required',
                'expired_date' => 'required',
                'file' => 'mimes:pdf',
            ];
        }else{
            $rules =  [
                'document_status' => 'required',
            ];
        }

        // return $request->all();

        $this->validate($request, $rules);
        $doc = MasterDocument::findOrFail($id);
        if($request->file('file')){
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('file')->storeAs('public/document', $filenameSimpan);

            MasterDocumentLog::create([
                'category_id'=> $doc->category_id,
                'vendor_id'=> $doc->vendor_id,
                'stockpile_id'=> $doc->stockpile_id,
                'file'=> $doc->file,
                'department'=> $doc->department,
                'expired_date'=> $doc->expired_date,
                'document_status'=> $doc->document_status,
                'document_name'=> $doc->document_name,
                'document_no'=> $doc->document_no,
                'document_date'=> $doc->document_date,
                'document_pic'=> $doc->document_pic,
                'remarks'=> $doc->remarks,
                'status'=> $doc->status,
                'created_by' => auth()->user()->id,
                ]);

            }else{
                $filenameSimpan = '';
            }

            $input = array_merge(['file' => $filenameSimpan], $request->except(['file','_method','_token']));

            $doc = MasterDocument::where('id',$id)->update($input);

            // return $doc;

            if(isset($request->vendor_id)){
                return redirect()->route('vendor.show',$request->vendor_id)->with(['success' => 'Success Submit Document!']);

            }else{
                return redirect()->route('stockpile.show',$request->stockpile_id)->with(['success' => 'Success Submit Document!']);
            }
        }

        /**
        * Remove the specified resource from storage.
        *
        * @param int $id
        * @return \Illuminate\Http\Response
        */
        public function destroy($id)
        {
            //
        }

        public function createDocumentStockpile($stockpileId, $categoryId){
            $doc = MasterDocument::where('category_id',$categoryId)->where('stockpile_id',$stockpileId)->first();

            return view('pages.document.create',compact('doc'));
        }
}
