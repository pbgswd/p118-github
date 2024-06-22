<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create committee']);
        Permission::create(['name' => 'manage committee']);
        Permission::create(['name' => 'delete committee']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'writer'])
            ->givePermissionTo(
                ['create articles', 'edit articles', 'publish articles', 'unpublish articles', 'delete articles']
            );

        $role = Role::create(['name' => 'member']);

        $role = Role::create(['name' => 'office'])
            ->givePermissionTo(['create users', 'edit users', 'delete users']);

        $role = Role::create(['name' => 'committee'])
            ->givePermissionTo(['create committee', 'manage committee', 'delete committee']);

        $role = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());
    }
}
