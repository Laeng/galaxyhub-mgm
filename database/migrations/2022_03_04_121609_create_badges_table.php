<?php

use App\Enums\BadgeType;
use App\Models\Badge;
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
        // badges table
        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // user_badges pivot
        Schema::create('user_badges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('badge_id');
            $table->timestamps();
        });

        $this->createBadge();
    }

    private function createBadge()
    {
        $badges = BadgeType::getKoreanNames();

        foreach ($badges as $key => $value)
        {
            Badge::create([
                'name' => $key,
                'description' => $value,
                'icon' => "images/badges/{$key}.svg"
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
    }
};
