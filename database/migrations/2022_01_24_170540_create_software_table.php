<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('version')->nullable();
            $table->integer('download_count')->default(0);
            $table->text('download_url')->nullable();
            $table->string('repo_provider')->nullable();
            $table->string('repo_url')->nullable();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('software');
    }
}
