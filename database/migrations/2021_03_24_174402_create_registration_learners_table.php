<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationLearnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_learners', function (Blueprint $table) {
            $table->id();
			$table->foreignId('learner_id')->constrained('learners');
			$table->foreignId('registration_id')->constrained('registrations');
			$table->enum('pass_status',['No Result','Passed','Faild'])->default('No Result');
			$table->string('cirtificate_no');
			$table->enum('is_printd',['No','Yes'])->default('No');
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
        Schema::dropIfExists('registration_learners');
    }
}
