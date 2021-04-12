<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    //
    public function index()
    {
        $testimonials = Testimonial::all();

        return view('website.testimonials', compact('testimonials'));
    }

    public function edit()
    {
        return view('frontend.testimonial-form');
    }

    public function store(Request $request)
    {
        $testimonial = $request->testimonial;
        $customer = auth('customer')->user();
        $name = $request->name ?? $customer->name;

        Testimonial::create([
           'customer_id' => $customer->id,
            'name' => $name,
            'testimonial' => $request->testimonial,
            'status' => false
        ]);

        return redirect('/');
    }

    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->status = 1;
        $testimonial->save();

        return redirect(route('testimonials'));
    }

    public function un_approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->status = 0;
        $testimonial->save();

        return redirect(route('testimonials'));
    }
}
