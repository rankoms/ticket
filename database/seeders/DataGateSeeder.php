<?php

namespace Database\Seeders;

use App\Models\EventGate;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class DataGateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ticket = Ticket::groupBy('event')->select('event')->get();

        $gate = [];
        foreach ($ticket as $key => $value) :
            for ($i = 1; $i <= 3; $i++) :
                array_push($gate, ['event' => $value->event, 'name' => 'Gate ' . $i]);
            endfor;
        endforeach;
        EventGate::insert($gate);
    }
}
