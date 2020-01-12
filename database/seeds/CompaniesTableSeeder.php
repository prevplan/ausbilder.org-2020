<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'TestHelp',
            'name_suffix' => 'John Doe',
            'street' => 'Musterstr. 1',
            'zipcode' => '12345',
            'location' => 'Beispielstadt',
            'reference' => '8.0000',
            'doctor' => 'Dr. Dolittle',
        ]);
    }
}
