<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomPass = '12345678';
        for ($i = 1; $i <= 10; $i++) :
            $insertUser = new User();
            $insertUser->name = 'admin' . $i;
            $insertUser->username = 'admin' . $i;
            $insertUser->email = 'admin' . $i . '@admin.com';
            $insertUser->password = Hash::make($randomPass);
            $insertUser->save();
        endfor;
    }
}
