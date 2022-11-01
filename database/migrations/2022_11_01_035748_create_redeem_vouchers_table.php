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
        Schema::create('redeem_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->index();
            $table->string('name', 100)->index();
            $table->string('email', 50)->index();
            $table->string('no_hp', 20)->index();
            $table->integer('status')->default(0)->index();
            $table->dateTime('redeem_date')->nullable();
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
