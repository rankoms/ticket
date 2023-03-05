<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformationColumnToTicketHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_histories', function (Blueprint $table) {
            $table->string('category', 255)->index();
            $table->string('gate', 255)->index();
            $table->string('status', 255)->index();
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
