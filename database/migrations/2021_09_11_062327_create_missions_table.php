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
            $table->tinyText('user_id'); // 진행자 정보
            $table->tinyInteger('type'); // 0: 일반 미션, 1: 아르마의 밤
            $table->tinyInteger('phase')->default(0); // 0: 참가자 모집, 1: 게임 시작, 2: 게임 종료, 3: 출석 마감
            $table->tinyText('code'); // 출석 코드
            $table->text('title');
            $table->longText('body');
            $table->mediumText('seat')->default('{}'); // 아르마 보직,  json -> key 값은 이름, value 값은 자리 수 // 추후 릴리즈 작업하기,
            $table->boolean('can_late'); // 중도 참여 가능 여부
            $table->integer('count')->default(0); //신청자 수
            $table->timestamp('expected_at'); // 예정 시간
            $table->timestamp('started_at'); // 시작 버튼 누른 시간
            $table->timestamp('ended_at'); // 시간
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
