<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standings',
            function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('league_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('team_rank')->unsigned();
            $table->integer('goals_for')->unsigned();
            $table->integer('goals_against')->unsigned();
            $table->integer('goals_difference');
            $table->integer('wins')->unsigned()->nullable()->default(0);
            $table->integer('losses')->unsigned()->nullable()->default(0);
            $table->integer('draws')->unsigned()->nullable()->default(0);
            $table->integer('points')->nullable()->default(0);
            $table->string('season', 10);
            $table->timestamps();

            $table->index('team_id');
            $table->index('league_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('standings');
    }
}
