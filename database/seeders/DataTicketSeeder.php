<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DataTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jumlah = 10000;
        $data = [];
        for ($i = 1; $i <= $jumlah; $i++) :

            if ($i <= 3000) {
                $event = 'Event 1';
            }
            if ($i <= 6000 && $i > 3000) {
                $event = 'Event 2';
            }
            if ($i <= 10000 && $i > 6000) {
                $event = 'Event 3';
            }

            for ($j=8; $j >= 1; $j--) { 
                if ($i % $j == 0) {
                    $category = 'Category '.$j;

                    break;
                }
            }

            array_push($data, [
                'event' => $event,
                'name' => 'Test',
                'email' => 'Test',
                'category' => $category,
                'barcode_no' => $i,
            ]);

            Ticket::insert($data);
            $data = [];
        endfor;
        // Ticket::insert($data);
    }
}
