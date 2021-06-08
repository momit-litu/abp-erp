<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
			$table->string('code');
			$table->string('name');
			$table->string('short_name');
			$table->string('address');
			$table->string('proprietor_name');
			$table->string('mobile_no');
			$table->string('liaison_office');
			$table->string('liaison_office_address');
			$table->string('email');
			$table->Double('agreed_minimum_invoice',8,2);
			$table->date('date_of_approval');
			$table->date('date_of_review');
			$table->enum('approval_status',['Pending','Approved','Rejected'])->default('Pending');
			$table->enum('status',['Active','Inactive'])->default('Active');
            $table->timestamps();
        });
    }
 /*code, name, short_name, address, proprietor_name,  mobile_no, liaison_office, liaison_office_address, email, 
 agreed_minimum_invoice, date_of_approval, date_of_review, approval_status, status */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centers');
    }
}
