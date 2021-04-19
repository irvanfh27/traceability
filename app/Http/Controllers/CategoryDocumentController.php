<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
use Illuminate\Http\Request;

class CategoryDocumentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryDocument::all();

        return view('pages.category-document.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category-document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'category_for' =>  'required'

        ]);

        $cat = CategoryDocument::create([
            'name' => $request->name,
            'category_for' => $request->category_for
        ]);

        if($request->next){
            return redirect()->route('category.create')->with(['success' => 'Success Submit Category!']);
        }else{
            return redirect()->route('category.index')->with(['success' => 'Success Submit Category!']);
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
        $category = CategoryDocument::findOrFail($id);

        return view('pages.category-document.create', compact('category'));
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
        $this->validate($request, [
            'name' => 'required',
            'category_for' =>  'required'
        ]);

        $cat = CategoryDocument::findOrFail($id);
        $cat->update([
            'name' => $request->name,
            'category_for' => $request->category_for
        ]);

        return redirect()->route('category.index')->with(['success' => 'Success Edit Category!']);
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

