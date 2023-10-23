<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatingChairVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seating_chair_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('event')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->integer('sort_row')->index();
            $table->integer('sort_column')->index();
            $table->string('name', 50)->index()->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('kode')->nullable()->index();
            $table->tinyInteger('is_seating')->default(0);
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
        Schema::dropIfExists('seating_chair_vouchers');
    }
}
