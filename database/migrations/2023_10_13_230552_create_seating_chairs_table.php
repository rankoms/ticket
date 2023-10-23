<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatingChairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seating_chairs', function (Blueprint $table) {
            $table->id();
            $table->string('event')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->integer('sort_row')->index();
            $table->integer('sort_column')->index();
            $table->string('name', 50)->index()->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('barcode_no')->nullable()->index();
            $table->tinyInteger('is_seating')->default(0);
            // $table->foreign('barcode_no')->references('barcode_no')->on("tickets");
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
        Schema::dropIfExists('seating_chairs');
    }
}
