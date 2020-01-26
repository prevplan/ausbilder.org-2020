<?php

use App\Position;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'company_id' => false,
            'position' => 'course leader'
        ]);

        Position::create([
            'company_id' => false,
            'position' => 'course helper'
        ]);

        Position::create([
            'company_id' => false,
            'position' => 'trainer'
        ]);
    }
}
