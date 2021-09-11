<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_missions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('mission_id')->index();
            $table->tinyText('role')->nullable(); // seat 컬럼의 역할들 중 하나를 선택한 값 // 추후 릴리즈
            $table->boolean('is_host')->default(false); // 진행자인지 아닌지
            $table->boolean('is_attend')->default(false); // 출석체크 여부
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
        Schema::dropIfExists('user_missions');
    }
}
