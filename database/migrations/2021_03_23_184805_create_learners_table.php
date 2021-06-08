<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
			$table->string('first_name'); 
			$table->string('last_name');
			$table->string('email');
			$table->string('contact_no');
			$table->string('address');
			$table->string('nid_no');
			$table->string('user_profile_image');			
			$table->mediumText('remarks');
			$table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
			$table->foreignId('center_id')->constrained('centers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learners');
    }
}
