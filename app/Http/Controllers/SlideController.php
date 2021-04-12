<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    //
    public function index() {
        $slideImages = Slider::all();
        return view('pages.slider', compact('slideImages'));
    }

    public function store(Request $request)
    {
        $name = $request->file('slide_image')->getClientOriginalName();
        $name = now() . str_replace(' ', '_', $name);
        $path = $request->file('slide_image')->storeAs('slider', $name);
        $path = 'storage/' .$path;

        Slider::create([
           'title' => $request->slide_title,
           'exert' => $request->slide_exert,
           'image' => $path,
        ]);

        return redirect(route('slider'));

    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if (file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        $slider->delete();

        return redirect(route('slider'));

    }
}
