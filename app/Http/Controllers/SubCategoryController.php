<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //
        $sub_categories = SubCategory ::latest()->get();
        $categories = Category ::latest()->get();

        return view('pages.sub_categories', compact('sub_categories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $name = $request->file('image')->getClientOriginalName();
        $name = now() . str_replace(' ', '_', $name);
        $path = $request->file('image')->storeAs('subcategory', $name);
        $path = 'storage/' .$path;

        SubCategory ::create([
            'name' => $request->name,
            'image' => $path,
            'category_id' => $request->category_id
        ]);

        return redirect(route('sub_categories.index'));
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
    public function edit(SubCategory $sub_category)
    {
        //
        $categories = Category::all();

        return view('pages.edit-sub_category', compact('sub_category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param SubCategory $sub_category
     *
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        //
        if ($request->file('image')) {

            $name = $request->file('image')->getClientOriginalName();
            $name = now() . str_replace(' ', '_', $name);
            $path = $request->file('image')->storeAs('category', $name);
            $path = 'storage/' .$path;

            if (file_exists(public_path($sub_category->image))) unlink(public_path($sub_category->image));
        } else {
            $path = $sub_category->image;
        }


        $sub_category->update([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect(route('sub_categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubCategory $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(SubCategory $sub_category)
    {
        //
        if (file_exists(public_path($sub_category->image)))
            unlink(public_path($sub_category->image));

        $sub_category->delete();

        return redirect()->back();
    }
}
