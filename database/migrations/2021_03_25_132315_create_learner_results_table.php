<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnerResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learner_results', function (Blueprint $table) {
            $table->id();			
			$table->foreignId('registration_learner_id')->constrained('registration_learners');
			$table->foreignId('unit_id')->constrained('units');			
			$table->string('result');
			$table->enum('passed',['No','Yes'])->default('No');
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
        Schema::dropIfExists('learner_results');
    }
}
