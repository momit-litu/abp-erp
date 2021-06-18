<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->unsignedDouble('course_fee', 11, 2)->default(0);
            $table->string('description', 500);
            $table->string('prerequisite', 300);
            $table->string('eligibility', 300);
            $table->string('cover_image', 191);
            $table->string('code', 191);
            $table->unsignedInteger('course_category_id')->index('courses_fk_course_category_id');
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
