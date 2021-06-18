<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191)->nullable();
            $table->string('code', 191);
            $table->unsignedInteger('course_id')->index('batches_fk_course_id');
            $table->integer('max_student_enrollment')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('days');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedTinyInteger('row_status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batches');
    }
}
