<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Color;
use App\Product;
use App\ProductSpecification;
use App\Size;
use App\SubCategory;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
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
        $sub_categories = SubCategory::all();
        $brands = Brand::all();

        return view('products.add-product', compact('categories', 'sub_categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
        $request->validate([
            'image_primary' => 'required|file|max:2000',
            'image_secondary' => 'required|file|max:2000',
            'image_left' => 'required|file|max:2000',
            'image_right' => 'required|file|max:2000',
        ]);

        $allSize = explode(',', $request->size);
        $allTags = explode(',', $request->tags);
        $tagCount = count($allTags);
        $sizeCount = count($allSize);
        $colorCount = count($request->color);

        $image_primary = $request->file('image_primary')->getClientOriginalName();
        $image_primary = now() . str_replace('', '_', $image_primary);
        $image_primary = $request->file('image_primary')->storeAs('product', $image_primary);
        $image_primary = 'storage/' .$image_primary;




        $image_secondary = $request->file('image_secondary')->getClientOriginalName();
        $image_secondary = now() . str_replace('', '_', $image_secondary);
        $image_secondary = $request->file('image_secondary')->storeAs('product', $image_secondary);
        $image_secondary = 'storage/' .$image_secondary;

        $image_left = $request->file('image_left')->getClientOriginalName();
        $image_left = now() . str_replace('', '_', $image_left);
        $image_left = $request->file('image_left')->storeAs('product', $image_left);
        $image_left = 'storage/' .$image_left;

        $image_right = $request->file('image_right')->getClientOriginalName();
        $image_right = now() . str_replace('', '_', $image_right);
        $image_right = $request->file('image_right')->storeAs('product', $image_right);
        $image_right = 'storage/' .$image_right;


        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image_primary' => $image_primary,
            'image_secondary' => $image_secondary,
            'image_left' => $image_left,
            'image_right' => $image_right,
        ]);

        for ($i=0; $i<$colorCount; $i++) {

            $color = Color::firstOrCreate([
                'name' => $request->color[$i]
            ]);

            $product->colors()->attach($color);
        }

        for ($i=0; $i<$sizeCount; $i++) {

            $size = Size::firstOrCreate([
                'name' => trim($allSize[$i])
            ]);

            $product->sizes()->attach($size);
        }

        for ($i=0; $i<$tagCount; $i++) {

            if (trim($allTags[$i]) != '') {

                $tag = Tag::firstOrCreate([
                    'name' => trim($allTags[$i])
                ]);

                if (!$product->tags->contains($tag->id)) {
                    $product->tags()->attach($tag);
                }
            }
        }
        ProductSpecification::create([
           'product_id' => $product->id,
           'compositions' => $request->compositions,
           'styles' => $request->styles,
           'properties' => $request->properties
        ]);

        return redirect(route('products.index'));
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
        $productId = $id;
        return view('products.show', compact('productId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $brands = Brand::all();

        return view('products.edit-product', compact('categories', 'sub_categories', 'product', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $allSize = explode(',', $request->size);
        $sizeCount = count($allSize);
        $colorCount = count($request->color);
        $allTags = explode(',', $request->tags);
        $tagCount = count($allTags);

        if ($request->file('image_primary')) {
            $image_primary = $request->file('image_primary')->getClientOriginalName();
            $image_primary = now() . str_replace('', '_', $image_primary);
            $image_primary = $request->file('image_primary')->storeAs('product', $image_primary);
            $image_primary = 'storage/' .$image_primary;

            if (file_exists(public_path($product->image_primary)))
                unlink(public_path($product->image_primary));
        } else {
            $image_primary = $product->image_primary;
        }

        if ($request->file('image_secondary')) {
            $image_secondary = $request->file('image_secondary')->getClientOriginalName();
            $image_secondary = now() . str_replace('', '_', $image_secondary);
            $image_secondary = $request->file('image_secondary')->storeAs('product', $image_secondary);
            $image_secondary = 'storage/' .$image_secondary;

            if (file_exists(public_path($product->image_secondary)))
                unlink(public_path($product->image_secondary));
        } else {
            $image_secondary = $product->image_secondary;
        }

        if ($request->file('image_left')) {
            $image_left = $request->file('image_left')->getClientOriginalName();
            $image_left = now() . str_replace('', '_', $image_left);
            $image_left = $request->file('image_left')->storeAs('product', $image_left);
            $image_left = 'storage/' .$image_left;

            if (file_exists(public_path($product->image_left)))
                unlink(public_path($product->image_left));
        } else {
            $image_left = $product->image_left;
        }

        if ($request->file('image_right')) {
            $image_right = $request->file('image_right')->getClientOriginalName();
            $image_right = now() . str_replace('', '_', $image_right);
            $image_right = $request->file('image_right')->storeAs('product', $image_right);
            $image_right = 'storage/' .$image_right;

            if (file_exists(public_path($product->image_right)))
                unlink(public_path($product->image_right));
        } else {
            $image_right = $product->image_right;
        }



        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'image_primary' => $image_primary,
            'image_secondary' => $image_secondary,
        ]);

        for ($i=0; $i<$colorCount; $i++) {

            $color = Color::firstOrCreate([
                'name' => $request->color[$i]
            ]);

            $colorList[] = $color->id;
        }

        $product->colors()->sync($colorList);

        for ($i=0; $i<$sizeCount; $i++) {

            $size = Size::firstOrCreate([
                'name' => trim($allSize[$i])
            ]);

            $sizeList[] = $size->id;

        }


        $product->sizes()->sync($sizeList);


        for ($i=0; $i<$tagCount; $i++) {

            if (trim($allTags[$i]) != '') {

                $tag = Tag::firstOrCreate([
                    'name' => trim($allTags[$i])
                ]);

                $tagList[] = $tag->id;

            }

        }

        $product->tags()->sync($tagList);



        $product->specifications()->update([
            'compositions' => $request->compositions,
            'styles' => $request->styles,
            'properties' => $request->properties
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        if (file_exists(public_path($product->image_primary))) {
            File::delete(public_path($product->image_primary));
        }
        if (file_exists(public_path($product->image_secondary))) {
            File::delete(public_path($product->image_secondary));
        }

        $product->delete();

        return redirect(route('products.index'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'products.csv';
        $products = Product::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'title', 'android_url', 'android_package', 'android_app_name', 'description', 'google_product_category',
            'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'sale_price', 'sale_price_effective_date', 'brand',
            'item_group_id', 'color', 'size');

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {

                $row['id']  = $product->id;
                $row['title']    = $product->name;
                $row['android_url']    = 'https://play.google.com/store/apps/details?id=com.vmsl.amar_shop&hl=en';
                $row['android_package']  = 'com.vmsl.amar_shop';
                $row['android_app_name']  = 'Amar Shop';
                $row['description']  = $product->description;
                $row['google_product_category']  = 'Health & Beauty > Personal Care';
                $row['product_type']  = $product->sub_category->name;
                $row['link']  = route('product-details', [$product->category->id, $product->sub_category->id, $product->id]);
                $row['image_link']  = asset($product->image_primary);
                $row['condition']  = 'New';
                $row['availability']  = $product->quantity > 0 ? 'In Stock' : 'Out of Stock';
                $row['price']  = $product->price;
                $discount = $product->sale ? $product->sale->percentage : $product->discount;
                $row['sale_price']  = $discount ? $product->price - round($product->price * $discount / 100) : $product->price;
                $row['sale_price_effective_date']  = $product->sale ? $product->sale->percentage : '';
                $row['brand']  = $product->brand->name;
                $row['item_group_id']  = $product->category->name;
                $colors = $product->colors;
                $row['color']  = $colors->implode('name', ', ');
                $sizes = $product->sizes;
                $row['size']  = $sizes->implode('name', ', ');

                fputcsv($file, array($row['id'], $row['title'] , $row['android_url'], $row['android_package'], $row['android_app_name'],
                    $row['description'], $row['google_product_category'], $row['product_type'], $row['link'], $row['image_link'], $row['condition'],
                    $row['availability'], $row['price'], $row['sale_price'], $row['sale_price_effective_date'], $row['brand'], $row['item_group_id'],
                    $row['color'], $row['size']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
