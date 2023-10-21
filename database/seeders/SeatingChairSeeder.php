<?php

namespace Database\Seeders;

use App\Models\SeatingChair;
use Illuminate\Database\Seeder;

class SeatingChairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $abjad = range('A', 'Z');
        for ($i = 1; $i <= 20; $i++) :
            for ($j = 1; $j <= 20; $j++) :
                $seating_chair = new SeatingChair();
                $seating_chair->sort_row = $i;
                $seating_chair->sort_column = $j;
                $seating_chair->name = $abjad[$i - 1] . $j;
                // $seating_chair->satuts = 
                $seating_chair->save();

            endfor;
        endfor;
    }
}
