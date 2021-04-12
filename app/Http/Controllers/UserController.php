<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $users = User::all();
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function store(UserRequest $request)
    {
        $data = $this->validator($request->all())->validate();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::findByName($request->role);

        $user->assignRole($role);

        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }

    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'super-admin')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    protected function update(User $user, UserRequest $request)
    {
        $data = $request->all();

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);


        $role = Role::findByName($request->role);

        $user->syncRoles([$role]);

        return redirect('/admin/users');
    }
}
