<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
    public function index()
    {
        $brands = Brand::latest()->get();

        return view('pages.brands', compact('brands'));
    }

    public function store(Request $request)
    {
        $name = $request->file('image')->getClientOriginalName();
        $name = now() . $name;
        $path = $request->file('image')->storeAs('brand', $name);
        $path = 'storage/' .$path;

        Brand::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect(route('brands.index'));
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
    public function edit(Brand $brand)
    {
        //
        return view('pages.edit-brand', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
        if ($request->file('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $name = now() . $name;
            $path = $request->file('image')->storeAs('brand', $name);
            $path = 'storage/' .$path;

            unlink(public_path($brand->image));
        } else {
            $path = $brand->image;
        }


        $brand->update([
            'name' => $request->name,
            'image' => $path,
        ]);

        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Brand $brand)
    {
        //
        if (file_exists(public_path($brand->image)))
            unlink(public_path($brand->image));

        $brand->delete();

        return redirect()->back();
    }

}
