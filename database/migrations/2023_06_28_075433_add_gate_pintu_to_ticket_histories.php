<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatePintuToTicketHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_histories', function (Blueprint $table) {
            //
            $table->string('gate_pintu_checkin')->nullable()->index();
            $table->string('gate_pintu_checkout')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_histories', function (Blueprint $table) {
            //
        });
    }
}
