<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CustomerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout_customer');
    }

    public function customer_login()
    {
        $categories = Category::all();

        return view('frontend.customer-login', compact('categories'));
    }

    public function register_customer(Request $request){
        $data = $request->validate([
           'email' => 'email|required|unique:customers',
           'password' => 'required|confirmed|min:6',
           'name' => 'required',
           'phone_number' => 'required',
        ]);

       $customer = Customer::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'customer_group_id' => 2
        ]);

		auth('customer')->loginUsingId($customer->id, true);

        session()->flash('message', 'Registration completed successfully!');
        session()->flash('alert-class', 'alert-success');

        if(count(session()->get('cart')) > 0){
            return redirect()->to('/checkout');
        }else{
            return redirect('my-account');
        }
        
    }

    public function login_customer(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials, $request->remember)) {
            if(session()->has('cart')){
                return redirect()->to('/cart');
            }else{
                return redirect('my-account');
            }

        }

        session()->flash('message', 'Credentials error!');
        session()->flash('alert-class', 'alert-danger');
        return redirect()->back();

//        $customer = Customer::where('email', $credentials['email'])->first();
//
//        if ($customer != null) {
//            if (password_verify($credentials['password'], $customer->password)) {
//                return redirect('my-account');
//            }
//        } else {
//            session()->flash('message', 'Credentials error!');
//            session()->flash('alert-class', 'alert-danger');
//            return redirect()->back();
//        }
    }

    public function logout_customer()
    {
        Auth::guard('customer')->logout();

        return redirect('/');

    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        switch ($provider) {
            case 'google':
                return Socialite::driver('google')->redirect();
                break;
            case 'facebook':
                return Socialite::driver('facebook')->redirect();
                break;
        }

    }


    public function handleProviderCallback($provider)
    {
        switch ($provider) {
            case 'google':
                try {
                    $user = Socialite::driver('google')->user();
                } catch (\Exception $e) {
                    return redirect('/customer-login');
                }
                break;
            case 'facebook':
                try {
                    $user = Socialite::driver('facebook')->user();
                } catch (\Exception $e) {
                    return redirect('/customer-login');
                }
                break;
        }


        // check if they're an existing user
        $existingCustomer = Customer::where('email', $user->email)->first();

        if($existingCustomer){
            // log them in
            auth('customer')->login($existingCustomer, true);
        } else {
            // create a new user
            $newCustomer                  = new Customer;
            $newCustomer->name            = $user->name;
            $newCustomer->email           = $user->email;
            $newCustomer->customer_group_id = 2;
            $newCustomer->save();

            auth('customer')->login($newCustomer, true);
        }
        if(session()->has('cart')){
            return redirect()->to('/cart');
        }else{
            return redirect()->to('/my-account');
        }


        
    }

}
