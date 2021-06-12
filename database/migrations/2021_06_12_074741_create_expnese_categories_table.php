<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpneseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		  Schema::create('expnese_categories', function (Blueprint $table) {
            $table->id();
			$table->string('category_name');
			$table->bigInteger('parent_id')->nullable();
			$table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
        });
    }
	// category_name,  parent_id, status
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expnese_categories');
    }
}
