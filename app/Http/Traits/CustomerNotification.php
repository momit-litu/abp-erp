<?php
namespace App\Traits;

use App\Models\StudentPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

trait CustomerNotification
{
    public function invoiceNotification($paymentId){
        $studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		Mail::to('momit.litu@gmail.com')->send(new CenterRegistrationNotification($payment));
	}

}
