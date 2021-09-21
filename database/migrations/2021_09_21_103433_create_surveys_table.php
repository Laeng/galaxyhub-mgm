<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 만든사람
            $table->unsignedBigInteger('original_id')->nullable()->index(); //수정되었다면, 원본 아이디를 저장한다.
            $table->string('type'); //applicant or mission
            $table->string('title')->nullable();
            $table->mediumtext('questions')->default('{}'); //json 형태, 질문과 질문 타입
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
        Schema::dropIfExists('surveys');
    }
}
