<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('visit')->default(1);
            $table->string('avatar')->nullable();
            $table->string('provider')->default('default');
            $table->string('username')->unique();
            $table->string('password')->nullable();
            $table->unsignedInteger('reputation')->default(0);
            $table->rememberToken();
            $table->timestamp('agreed_at')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('visited_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->char('provider', 20)->comment('oauth provider');
            $table->string('account_id')->comment('account id from oauth provider');
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->string('access_token', 500)->nullable();
            $table->string('refresh_token', 500)->nullable();
            $table->timestamps();
        });

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

        Schema::create('user_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('staff_id')->index()->nullable();
            $table->string('type');
            $table->longText('data')->nullable();
            $table->uuid()->index()->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_accounts');
        Schema::dropIfExists('user_missions');
        Schema::dropIfExists('user_record');

    }
};
