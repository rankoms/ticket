<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('event')->index();
            $table->string('category')->index();
            $table->string('name')->index();
            $table->string('email')->index();
            $table->string('no_telp')->index();
            $table->integer('quantity')->index();
            $table->double('harga_satuan')->index();
            $table->double('total_harga')->index();
            $table->string('barcode_no')->index();
            $table->string('payment_code')->index();
            $table->integer('user_id')->index()->nullable();
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
        Schema::dropIfExists('pos_tickets');
    }
}
