<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Console\Command;

class SendSyncLocalToCloud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_sync_to_cloud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        $ticket = Ticket::where('status', true)->get();
        $ticket_history = TicketHistory::where('status', true)->get();


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => \config('scanner.cloud_url') . '/api/scanner/sync',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "tickets": ' . json_encode($ticket) . ',
    "ticket_histories": ' . json_encode($ticket_history) . '
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        TicketHistory::where('status', true)->update(['status' => false]);
        Ticket::where('status', true)->update(['status' => false]);
        return $response;
    }

    public function send_ticket($ticket = [], $ticket_history = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://127.0.0.1:9091/api/scanner/sync',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "tickets": ' . json_encode($ticket) . ',
    "ticket_histories": ' . json_encode($ticket_history) . '
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
        echo $response;
    }
}
