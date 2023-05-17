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
        $jumlah = 1000;
        $data = [];
        for ($i = 1; $i <= $jumlah; $i++) :

            if ($i <= 300) {
                $event = 'Event 1';
            }
            if ($i <= 600 && $i > 300) {
                $event = 'Event 2';
            }
            if ($i <= 1000 && $i > 600) {
                $event = 'Event 3';
            }

            for ($j = 8; $j >= 1; $j--) {
                if ($i % $j == 0) {
                    $category = 'Category ' . $j;

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
