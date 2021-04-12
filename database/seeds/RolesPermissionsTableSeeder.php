<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $delivery = Role::create(['name' => 'delivery']);

        $access_admin_data = Permission::create(['name' => 'access-admin-data']);
        $access_manager_data = Permission::create(['name' => 'access-manager-data']);
        $access_delivery_data = Permission::create(['name' => 'access-delivery-data']);

        $admin->givePermissionTo($access_admin_data);
        $manager->givePermissionTo($access_manager_data);
        $delivery->givePermissionTo($access_delivery_data);

    }
}
