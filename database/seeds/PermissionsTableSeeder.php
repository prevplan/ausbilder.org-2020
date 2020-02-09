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

        Permission::create([
            'name' => 'trainer.add',
            'display_name' => 'add new trainer',
            'description' => 'can add new trainer',
        ]);

        Permission::create([
            'name' => 'course.add',
            'display_name' => 'add new course',
            'description' => 'can add a new course',
        ]);

        Permission::create([
            'name' => 'course.view',
            'display_name' => 'view courses',
            'description' => 'can see courses',
        ]);

        // attach all permissions to user one
        User::find(1)->attachPermissions(Permission::all(), 1);
    }
}
