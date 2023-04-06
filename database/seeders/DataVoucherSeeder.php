<?php

namespace Database\Seeders;

use App\Models\RedeemVoucher;
use Illuminate\Database\Seeder;

class DataVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'nama_perusahaan' => 'a',
                'kategory' => 1,
                'seat' => 1,
                'kode' => 1,
                'name' => 'aaa',
                'email' => 'email@email.com',
                'no_hp' => 123,
                'no_ktp' => 123,
            ]
        ];
        $data = array();
        for ($i = 0; $i <= 100; $i++) {
            array_push(
                $data,
                [

                    'nama_perusahaan' => 'a',
                    'kategory' => 1,
                    'seat' => 1,
                    'kode' => $i,
                    'name' => 'aaa' . $i,
                    'email' => 'email@email.com',
                    'no_hp' => 123,
                    'no_ktp' => 123,
                ]
            );
        }
        RedeemVoucher::insert($data);
    }
}
