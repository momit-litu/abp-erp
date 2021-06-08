<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualification_units', function (Blueprint $table) {
            $table->id();
			$table->foreignId('unit_id')->constrained('units');
			$table->foreignId('qualification_id')->constrained('qualifications');
			$table->enum('type',['Optional','Mandatory'])->default('Optional');
			$table->enum('status',['Active','Inactive'])->default('Active');
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
        Schema::dropIfExists('qualification_units');
    }
}
