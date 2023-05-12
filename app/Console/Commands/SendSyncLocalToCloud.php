<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        try {
            DB::beginTransaction();
            $datetime = date('Y-m-d H:i:s');
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

<<<<<<< HEAD
            Ticket::where('status', true)->update(['status' => true]);
            TicketHistory::where('status', true)->update(['status' => false]);
=======
            Ticket::where('status', true)->where('updated_at', '<', $datetime)->update(['status' => false]);
            TicketHistory::where('status', true)->where('created_at', '<', $datetime)->update(['status' => false]);
>>>>>>> ffd74a7c2fd7a204c128deb0dbf82d5f09590ca4
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
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
