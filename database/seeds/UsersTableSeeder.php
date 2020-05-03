<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for development use only
        /*
        User::create([
            'name' => 'John Doe',
            'email' => 'test@test.fail',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('123456'),
            'last_company' => 1,
        ])->companies()->attach(
            1,
            [
                'company_active' => 1,
                'user_active' => 1,
            ]
        );
        */
    }
}
