<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserRedeem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_user_redeem';

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
        $randomPass = '12345678';
        for ($i = 1; $i <= 10; $i++) :
            $insertUser = new User();
            $insertUser->name = 'admin ' . $i;
            $insertUser->username = 'admin ' . $i;
            $insertUser->email = 'admin' . $i . '@admin.com';
            $insertUser->password = Hash::make($randomPass);
            $insertUser->save();
        endfor;
    }
}
