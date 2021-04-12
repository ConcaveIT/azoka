<?php

namespace App\Http\Controllers;

use App\FeaturedProduct;
use App\Product;
use Illuminate\Http\Request;

class FeaturedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        //
        $products = Product::latest()->where('is_active', 1)->get();
        $featuredProducts = Product::where('featured', 1)->latest()->get();


        return view('website.featured', compact( 'products', 'featuredProducts'));
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
        //
        $product = Product::findOrFail($request->product_id);

        $product->update([
            'featured' => 1,
        ]);

        return redirect(route('featured.index'));
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
        //
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
        //
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
        $featuredProduct = Product::findOrFail($id);

        $featuredProduct->update([
            'featured' => 0
        ]);

        return redirect(route('featured.index'));
    }
}
