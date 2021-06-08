<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
			$table->id();
			$table->string('registration_no'); 
			$table->string('invoice_no');
			$table->Double('registration_fees',8,2);
			$table->Double('fees_paid_amount',8,2);
			
			$table->date('center_registration_date');
			$table->date('ep_registration_date');	
			$table->date('result_claim_date');				
			
			$table->enum('status',['Active','Inactive'])->default('Active');
			$table->enum('approval_status',['Initiated','Requested','Accepted','Result Claimed','Rejected'])->default('Initiated');
            $table->enum('payment_status',['Due','Paid','Partial'])->default('Due');
			
			$table->mediumText('remarks');
			$table->timestamps();
			$table->foreignId('center_id')->constrained('centers');
			$table->foreignId('qualification_id')->constrained('qualifications');
        });
    }
/*
'registration_no', 'invoice_no', 'registration_fees','fees_paid_amount', 'center_registration_date',
'ep_registration_date', 'result_claim_date', 'status', 'approval_status', 'payment_status', 'remarks', 'center_id', 'qualification_id'

*/
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
