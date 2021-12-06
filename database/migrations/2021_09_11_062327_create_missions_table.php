<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 메이커의 회원 아이디
            $table->unsignedBigInteger('survey_id')->nullable(); //미션 설문을 가져온다.
            $table->tinyInteger('type'); // 0: 일반 미션, 1: 아르마의 밤
            $table->tinyInteger('phase')->default(0); // 0: 참가자 모집, 1: 게임 시작, 2: 게임 종료, 3: 출석 마감
            $table->tinyText('code'); // 출석 코드
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('data')->nullable(); //추가 데이터
            $table->boolean('can_tardy')->default(false); // 중도 참여 가능 여부
            $table->integer('count')->default(0); //신청자 수
            $table->timestamp('expected_at')->nullable(); // 예정 시간
            $table->timestamp('started_at')->nullable(); // 시작 버튼 누른 시간
            $table->timestamp('ended_at')->nullable(); // 끝난 시간
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
        Schema::dropIfExists('missions');
    }
}
