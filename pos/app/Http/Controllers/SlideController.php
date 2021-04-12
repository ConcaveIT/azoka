<?php

namespace App\Http\Controllers;

use App\Category;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SlideController extends Controller
{
    //
    public function index() {
        $slideImages = Slider::all();
        return view('website.sliders', compact('slideImages'));
    }

    public function store(Request $request)
    {
        $request->title = preg_replace('/\s+/', ' ', $request->title);
        $this->validate($request, [
            'slide_title' => [
                'max:255',
            ],
            'slide_exert' => 'max:255',
            'slide_image' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        $image = $request->slide_image;

        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis");
            $imageName = $imageName . '.' . $ext;
            $image->move('images/slider', $imageName);

            $silder_data['image'] = $imageName;
        }
        $silder_data['title'] = $request->slide_title;
        $silder_data['exert'] = $request->slide_exert;

        Slider::create($silder_data);

        return redirect('sliders')->with('message', 'Slider created successfully');

    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if($slider->slide_image)
            unlink('images/slider/'.$slider->slide_image);

        $slider->delete();

        return redirect('sliders')->with('not_permitted', 'Category deleted successfully');

    }
}
