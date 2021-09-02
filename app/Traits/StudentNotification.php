<?php
namespace App\Traits;

use App\Models\Student;
use App\Mail\InvoiceMail;
use Illuminate\Support\Str;
use App\Models\BatchStudent;
use App\Models\StudentPayment;
use App\Mail\paymentRevisedMail;
use App\Mail\studentEnrollmentMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\studentRegistrationMail;
use App\Mail\monthlyPaymentRequestMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\studentRegistrationConfirmMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait StudentNotification
{
    public function invoiceEmail($paymentId){
        $studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		Mail::to($payment['student_email'])->send(new InvoiceMail($payment));
		Log::debug('step4');
	}
    public function registrationEmail($studentId){
        $student = Student::find($studentId);
		Mail::to($student['email'])->send(new studentRegistrationMail($student));
		Log::debug('step4');
	}
	public function enrollmentEmail($enrollmentId){
		$studentPayments = BatchStudent::with('payments','student','batch','batch.course','batch_fee','batch_fee.installments')->find($enrollmentId);
		Mail::to($studentPayments['student']['email'])->send(new studentEnrollmentMail($studentPayments));
		Log::debug('step4');
	}

	public function paymentRevisedEmail($enrollmentId){
		$studentPayments = BatchStudent::with('payments','student','batch','batch.course','batch_fee','batch_fee.installments')->find($enrollmentId);
		Mail::to($studentPayments['student']['email'])->send(new paymentRevisedMail($studentPayments));
		Log::debug('step4');
	}

	public function monthlyPaymentEmail($paymentId){
		$studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		Mail::to($payment['student_email'])->send(new monthlyPaymentRequestMail($payment));
		Log::debug('step4');
	}

	public function registrationConfirmEmail($studentId){
        $student = Student::find($studentId);
		Mail::to($student['email'])->send(new studentRegistrationConfirmMail($student));
		Log::debug('step4');
	}
	

}
