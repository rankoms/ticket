<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // $table->integer('order_id')->index();
            $table->string('event', 255)->index();
            $table->string('name', 255)->index()->nullable();
            $table->string('email', 100)->index()->nullable();
            $table->string('category', 255)->index();
            $table->string('barcode_no')->unique()->index();
            // $table->string('ticket_type')->default('reguler')->nullable()->index();
            $table->dateTime('checkin')->nullable()->index();
            $table->dateTime('checkout')->nullable()->index();
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
        Schema::dropIfExists('tickets');
    }
}
