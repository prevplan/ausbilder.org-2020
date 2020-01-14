<?php

use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'company.edit',
            'display_name' => 'edit company',
            'description' => 'can edit the company',
        ]);

        Permission::create([
            'name' => 'permissions.edit',
            'display_name' => 'edit permissions',
            'description' => 'can edit permissions',
        ]);

        Permission::create([
            'name' => 'course-types.edit',
            'display_name' => 'edit course types',
            'description' => 'can edit course types',
        ]);

        // attach all permissions to user one
        User::find(1)->attachPermissions(Permission::all(), 1);
    }
}
