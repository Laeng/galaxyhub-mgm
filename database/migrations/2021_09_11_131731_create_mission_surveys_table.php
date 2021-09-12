<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('mission_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); //참가자 아이디
            $table->unsignedBigInteger('mission_id')->index(); //참가 미션
            $table->unsignedBigInteger('survey_id'); //설문 질문 아이디
            $table->mediumText('response')->default('{}');
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('mission_surveys');
    }
}
