<?php

namespace App\Http\Controllers;

use App\User;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $activities = Activity::latest()->get();

        $users = User::where('email', '!=', 'superadmin@amarshop.com.bd')->latest()->get();

        return view('dashboard', compact('activities', 'users'));
    }

    public function destroy_activity(Activity $activity)
    {

    }
}
