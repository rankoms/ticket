<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        $harga_satuan = [100000, 200000, 300000, 400000];
        for ($i = 1; $i <= 3; $i++) :

            for ($j = 1; $j <= 3; $j++) :
                array_push($data, ['event' => 'Event ' . $i, 'category' => 'Category ' . $j, 'harga_satuan' => $harga_satuan[array_rand($harga_satuan)]]);
            endfor;
        endfor;

        EventCategory::insert($data);
    }
}
