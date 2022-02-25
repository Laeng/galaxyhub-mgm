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
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name')->index();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_question_id');
            $table->unsignedInteger('survey_entry_id')->nullable();
            $table->mediumText('value');
            $table->timestamps();
        });

        Schema::create('survey_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id');
            $table->unsignedInteger('participant_id')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id')->nullable();
            $table->unsignedInteger('survey_section_id')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('text');
            $table->json('options')->nullable();
            $table->json('rules')->nullable();
            $table->timestamps();
        });

        Schema::create('survey_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('survey_answers');
        Schema::dropIfExists('survey_entries');
        Schema::dropIfExists('survey_questions');
        Schema::dropIfExists('survey_sections');
    }
};
