<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
			$table->string('code');
			$table->string('title');
			$table->integer('tqt');
			$table->Double('registration_fees',8,2);
			$table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
			$table->foreignId('level_id')->constrained('levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualifications');
    }
}
