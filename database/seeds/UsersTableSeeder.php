<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = Factory(App\User::class)->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@amarshop.com.bd',
            'email_verified_at' => now(),
            'password' => bcrypt('superadmin.amarshop'), // password
            'remember_token' => Str::random(10),
        ]);

        $role = Role::create(['name'=>'super-admin']);
        $permission = Permission::create([
           'name' => 'access-all-data'
        ]);

        $role->givePermissionTo($permission);

        $user->assignRole($role);


    }
}
