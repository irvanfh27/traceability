<?php

namespace App\Http\Controllers;

use App\FollowUpDocument;
use Illuminate\Http\Request;

class FollowUPDocumentController extends Controller
{
        /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($vendorId)
    {
        return view('pages.followUp.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // return $request->route()->parameters;
        $this->validate($request,[
            'date_follow_up' => 'required',
            'keterangan' => 'required',
            'yang_menghubungi' => 'required',
            'yang_di_hubungi' =>'required'
        ]);

       $followUp = FollowUpDocument::create($request->except('_token'));

        return redirect()->route('vendor.show',$request->vendor_id)->with(['success' => 'Success Submit Follow Up!']);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $followUp = FollowUpDocument::findOrFail($id);

        return view('pages.followUp.create',compact('followUp'));
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
        $this->validate($request,[
            'date_follow_up' => 'required',
            'keterangan' => 'required',
            'yang_menghubungi' => 'required',
            'yang_di_hubungi' =>'required'
        ]);

       $followUp = FollowUpDocument::findOrFail($id)->update($request->except('_token','vendor_id'));

        return redirect()->route('vendor.show',$request->vendor_id)->with(['success' => 'Success Update Follow Up!']);;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}

