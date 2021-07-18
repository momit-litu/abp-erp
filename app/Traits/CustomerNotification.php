<?php
namespace App\Traits;

use App\Models\StudentPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerInvoice;
use Illuminate\Support\Facades\Log;

trait CustomerNotification
{
    public function invoiceNotification($paymentId){
		Log::debug('step1');
        $studentPayment = new StudentPayment();
		Log::debug('step2');
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		Mail::to('momit.litu@gmail.com')->send(new CustomerInvoice($payment));
		Log::debug('step4');
	}

}
