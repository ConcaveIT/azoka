<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function privacy_policy()
    {
        $page = Page::first();

        return view('website.pages.privacy-policy', compact('page'));
    }

    public function terms_conditions()
    {
        $page = Page::first();

        return view('website.pages.terms-conditions', compact('page'));
    }

    public function returns_exchange()
    {
        $page = Page::first();

        return view('website.pages.returns-exchange', compact('page'));
    }

    public function disclaimer()
    {
        $page = Page::first();

        return view('website.pages.disclaimer', compact('page'));
    }

    public function about_us()
    {
        $page = Page::first();

        return view('website.pages.about-us', compact('page'));
    }

    public function contact_us()
    {
        $page = Page::first();

        return view('website.pages.contact-us', compact('page'));
    }


    //
    public function policies()
    {
        $page = Page::first();

        return view('website.policies', compact('page'));
    }

    public function customer_care()
    {
        $page = Page::first();

        return view('website.customer-care', compact('page'));
    }



    public function policies_store(Request $request)
    {
        $page = Page::first();

        if (!$page) {
            $page = Page::create([
                'terms_conditions' => $request->terms_conditions,
                'delivery_returns' => $request->delivery_returns,
                'privacy_policy' => $request->privacy_policy
            ]);
        }

        $page->update([
            'terms_conditions' => $request->terms_conditions,
            'delivery_returns' => $request->delivery_returns,
            'privacy_policy' => $request->privacy_policy
        ]);

        return redirect(route('policies'));
    }

    public function customer_care_store(Request $request)
    {
        $page = Page::first();

        if (!$page) {
            $page = Page::create([
                'about_us' => $request->about_us,
                'returns_exchange' => $request->returns_exchange,
                'contact_us' => $request->contact_us
            ]);
        }

        $page->update([
            'about_us' => $request->about_us,
            'returns_exchange' => $request->returns_exchange,
            'contact_us' => $request->contact_us
        ]);

        return redirect(route('customer-care'));
    }

}
