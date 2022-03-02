<?php
namespace App\Traits;

use App\Models\User;
use App\Mail\bulkMail;
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
use App\Notifications\newStudentCreated;
use App\Notifications\newStudentEnrolled;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\newPaymentByStudent;
use App\Mail\studentRegistrationConfirmMail;
use App\Notifications\newStudentEnrolledOwn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\duePaymentNotification;
use App\Notifications\newPaymentByStudentOwn;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait StudentNotification
{
	// email notifications
    public function invoiceEmail($paymentId){
        $studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		Mail::to($payment['student_email'])->send(new InvoiceMail($payment));
	}

    public function registrationEmail($studentId){
        $student = Student::find($studentId);
		Mail::to($student['email'])->send(new studentRegistrationMail($student));
	}

	public function enrollmentEmail($enrollmentId){
		$studentPayments = BatchStudent::with('payments','student','batch','batch.course','batch_fee','batch_fee.installments')->find($enrollmentId);
		//dd($studentPayments);
		Mail::to($studentPayments['student']['email'])->send(new studentEnrollmentMail($studentPayments));
	}

	public function paymentRevisedEmail($enrollmentId){
		$studentPayments = BatchStudent::with('payments','student','batch','batch.course','batch_fee','batch_fee.installments')->find($enrollmentId);
		Mail::to($studentPayments['student']['email'])->send(new paymentRevisedMail($studentPayments));
	}

	// not using yet ???
	public function monthlyPaymentEmail($paymentId){
		$studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		$this->duePaymentNotification($payment); 
		Mail::to($payment['student_email'])->send(new monthlyPaymentRequestMail($payment));
	}
	// not using yet ???
	public function duePaymentEmail($paymentId){
		$studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);
		$this->duePaymentNotification($payment); 
		Mail::to($payment['student_email'])->send(new monthlyPaymentRequestMail($payment));
	}

	public function registrationConfirmEmail($studentId){
        $student = Student::find($studentId);
		Mail::to($student['email'])->send(new studentRegistrationConfirmMail($student));
	}
	
	
	public function bulkEmail($emails){
		try{
			foreach($emails as $email){	
				$sendEmail = Mail::to( $email['address'])->send(new bulkMail( $email['title'],  $email['body']));
			}
			$return['response_code'] 	= 1;
			$return['message'] 			= "Mail Sent";
			return $return;
		} 
		catch (\Exception $e){
			$return['response_code'] 	= 0;
			$return['message'] 			=  $e->getMessage();
			return $return;
		}


		return $sendEmail;
	}


	
	
	//DB notifications
	public function studentPaymentPaidNotification($payment){
		$notifyUsers = User::where('status','1')->where('type','Admin')->get();
		Notification::send($notifyUsers, new newPaymentByStudent(array('type'=>'Success', 'studentName'=>$payment->enrollment->student->name, 'paymentId'=>$payment->id, 'paymentAmount'=>$payment->paid_amount )));

		$notifyUser = User::where('student_id',$payment->enrollment->student->id)->get();
		Notification::send($notifyUser, new newPaymentByStudentOwn(array('type'=>'Success',  'paymentId'=>$payment->id, 'paymentAmount'=>$payment->paid_amount )));
	}

	public function registrationCompletedNotification($student){
		$notifyUsers = User::where('status','1')->where('type','Admin')->get();
        Notification::send($notifyUsers, new newStudentCreated(array('type'=>'Success', 'studentName'=>$student->name, 'studentId'=>$student->id,  )));	
	}

	public function courseEnrollmentNotificationForAdmin($batchStudent){
		$notifyUsers = User::where('status','1')->where('type','Admin')->get();
        Notification::send($notifyUsers, new newStudentEnrolled(array('type'=>'Success', 'studentName'=>$batchStudent->student->name, 'studentId'=>$batchStudent->student->id,  'courseName'=>$batchStudent->batch->course->title )));	
	}

	public function courseEnrollmentNotificationForStudent($batchStudent){
		$notifyUser = User::where('student_id',$batchStudent->student->id)->get();
        Notification::send($notifyUser, new newStudentEnrolledOwn(array('type'=>'Success', 'studentId'=>$batchStudent->student_id, 'courseId'=>$batchStudent->batch_id, 'courseName'=>$batchStudent->batch->course->title )));
	}

	public function duePaymentNotification($payment){

		/*$studentPayment = new StudentPayment();
		$payment = 	$studentPayment->getPaymentDetailByPaymentId($paymentId);*/
		$notifyUser = User::where('student_id',$payment['student_id'])->get();
		Notification::send($notifyUser, new duePaymentNotification(array('type'=>'Success',  'paymentId'=>$payment['id'], 'paymentAmount'=>$payment['paid_amount'] )));
	}

}
