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
            'name' => 'course leader',
        ]);

        Position::create([
            'company_id' => false,
            'name' => 'course helper',
        ]);

        Position::create([
            'company_id' => false,
            'name' => 'trainer',
        ]);
    }
}
