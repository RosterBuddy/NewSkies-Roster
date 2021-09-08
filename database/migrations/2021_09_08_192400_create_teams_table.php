<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('team_name');
            $table->timestamps();
        });

        DB::table('teams')->insert(["team_name" => "Unassigned", "created_at" => NOW(), "updated_at" => NOW()]);
        DB::table('teams')->insert(["team_name" => "Coms", "created_at" => NOW(), "updated_at" => NOW()]);
        DB::table('teams')->insert(["team_name" => "Disruptions", "created_at" => NOW(), "updated_at" => NOW()]);
        DB::table('teams')->insert(["team_name" => "Reaccom", "created_at" => NOW(), "updated_at" => NOW()]);
        DB::table('teams')->insert(["team_name" => "Systems", "created_at" => NOW(), "updated_at" => NOW()]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
