<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedeemVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // nama perusahaan , kategory , seat , dll
        Schema::create('redeem_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan', 100)->index()->nullable();
            $table->string('kategory', 50)->index()->nullable();
            $table->string('seat', 20)->index()->nullable();
            $table->string('kode', 50)->index()->nullable();
            $table->string('name', 100)->index()->nullable();
            $table->string('email', 50)->index()->nullable();
            $table->string('no_hp', 20)->index()->nullable();
            $table->string('no_ktp', 20)->index()->nullable();
            $table->integer('status')->default(0)->index();
            $table->dateTime('redeem_date')->nullable();
            $table->integer('redeem_by')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redeem_vouchers');
    }
}
