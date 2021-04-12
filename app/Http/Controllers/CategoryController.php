<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();

        return view('pages.categories', compact('categories'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->file('image')->getClientOriginalName();
        $name = now() . str_replace(' ', '_', $name);
        $path = $request->file('image')->storeAs('category', $name);
        $path = 'storage/' .$path;

        Category::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect(route('categories.index'));
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
    public function edit(Category $category)
    {
        //
        return view('pages.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        if ($request->file('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $name = now() . str_replace(' ', '_', $name);
            $path = $request->file('image')->storeAs('category', $name);
            $path = 'storage/' .$path;

            if (file_exists(public_path($category->image)))
                unlink(public_path($category->image));

        } else {
            $path = $category->image;
        }


        $category->update([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        //
        if (file_exists(public_path($category->image)))
            unlink(public_path($category->image));

        $category->delete();

        return redirect()->back();
    }
}
