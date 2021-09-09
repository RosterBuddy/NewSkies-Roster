<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosterTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->time('shift_start');
            $table->time('shift_end');
            $table->timestamps();
        });

        DB::table('timings')->insert(["name" => "Early", "shift_start" => "06:00" , "shift_end" => "17:00", "created_at" => NOW(), "updated_at" => NOW()]);
        DB::table('timings')->insert(["name" => "Late", "shift_start" => "12:00" , "shift_end" => "23:00", "created_at" => NOW(), "updated_at" => NOW()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
