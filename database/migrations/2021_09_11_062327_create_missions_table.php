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
            //$table->unsignedBigInteger('survey_id')->nullable(); //미션 설문을 가져온다. survey 테이블을 만들어서 설문 내용, 설문 응답 타입 (주관식, 객관식등등), 고유 아이디, 미션 아이디, 필수 응답 여부, parents 아이디을 각 문항별로 개별 등록 그리고 survey_answer 에 설문에 대한 답변을 아이디, 서베이 아이디, 유저 아이디, 미션 아이디, 답변 (텍스트로), 질문 타입 (주관식, 객관식 등등)
            //$table->unsignedBigInteger('seat_id')->nullable(); // 미션 역할 설정을 한다. seat 테이블을 만들어서 역할 이름, 신청자 수, 최대 신청자, 미션 아이디, 고유 아이디, parents 여부, parents 아이디 저장을 한다. 일대다 릴레이션쉽을 맺어야 하므로, 각각 역할 마다 로우를 만든다.
            $table->tinyInteger('type'); // 0: 일반 미션, 1: 아르마의 밤
            $table->tinyInteger('phase')->default(0); // 0: 참가자 모집, 1: 게임 시작, 2: 게임 종료, 3: 출석 마감
            $table->tinyText('code'); // 출석 코드
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
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
