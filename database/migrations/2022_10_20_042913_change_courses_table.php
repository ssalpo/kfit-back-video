<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('course_type')->default(\App\Constants\Course::TYPE_COURSE);
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->string('level', 50)->nullable()->change();
            $table->string('direction', 50)->nullable()->comment('направление');
            $table->string('active_area', 50)->nullable()->comment('активная зона');
            $table->string('inventory', 50)->nullable()->comment('инвентарь');
            $table->string('pulse_zone', 50)->nullable()->comment('пульсовая зона');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('level')->default(\App\Constants\Course::LEVEL_BEGINNER);
            $table->dropColumn([
                'course_type',
                'trainer_id',
                'direction',
                'active_area',
                'inventory',
                'pulse_zone',
            ]);
        });
    }
};
