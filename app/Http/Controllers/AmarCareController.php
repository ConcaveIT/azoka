<?php

namespace App\Http\Controllers;

use App\AmarCare;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AmarCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $amarcares = AmarCare::latest()->get();

        return view('amarcare.index', compact('amarcares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $products = Product::all();

        return view('amarcare.add-vlog', compact('categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $image = $request->file('image')->getClientOriginalName();
        $image = now() . $image;
        $image = $request->file('image')->storeAs('amarcare', $image);
        $image = 'storage/' .$image;


        $vlog = AmarCare::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'video' => $request->video,
            'description' => $request->description,
        ]);

        $vlog->products()->sync($request->products);

        return redirect(route('amar-care.index'));
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
        $amarcare = AmarCare::findOrFail($id);
        $categories = Category::all();

        return view('amarcare.edit-vlog', compact('amarcare', 'categories'));
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
        $amarcare = AmarCare::findOrFail($id);

        if ($request->file('image')) {

            $image = $request->file('image')->getClientOriginalName();
            $image = $request->file('image')->storeAs('amarcare', $image);
            $image = 'storage/' .$image;

            if (file_exists(public_path($amarcare->imges))) {
                unlink(public_path($amarcare->image));
            }

        } else {
            $image = $amarcare->image;
        }

        $amarcare->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'video' => $request->video,
            'description' => $request->description,
        ]);

        return redirect(route('amar-care.index'));
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

        $amarcare = AmarCare::findOrFail($id);

        $amarcare->delete();

        return redirect(route('amar-care.index'));
    }
}
