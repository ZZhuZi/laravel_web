<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyGuessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_guess', function (Blueprint $table) {
            $table->increments('id');
            $table->string('team_a')->comment('球队A');
            $table->string('team_b')->comment('球队A');
            $table->char('end_at',32)->comment('过期时间');
            $table->enum('result',['1','2','3'])->default('1')->comment('胜负结果 1 平 2 胜 3 负');
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
        Schema::dropIfExists('study_guess');
    }
}
