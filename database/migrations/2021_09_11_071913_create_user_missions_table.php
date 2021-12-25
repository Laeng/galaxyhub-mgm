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
            $table->mediumText('role')->nullable(); // 아르마의 밤 과 같은 역할들 중 하나를 선택한 값 // 추후 릴리즈
            $table->boolean('is_maker')->default(false); // 진행자인지 아닌지
            $table->tinyInteger('try_attends')->default(0);
            $table->timestamp('attended_at')->nullable(); // 출석체크 시간
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
