<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class centerRegistrationNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($center, $type)
    {
        $this->center 	= $center;
		$this->type		= $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		//echo mail('app.from');die;
		//Active Inactive Approve Reject
		if($this->type =='Approve'){
			return $this->subject('Edupro Center registration confirmation')
			->markdown('mails.center-registration-approve')
			->with([
				'center' => $this->center,
			]);
		}
		else if($this->type =='Reject'){
			 return $this->subject('Edupro Center regiistration rejected')
				->markdown('mails.center-registration-reject')
				->with([
					'center' => $this->center,
				]);
		}
		else if($this->type =='Active'){
			return $this->subject('Edupro Center account activated')
				->markdown('mails.center-registration-active')
				->with([
					'center' => $this->center,
				]);
		}
		else if($this->type =='Inactive'){
			return $this->subject('Edupro Center account deactivated')
				->markdown('mails.center-registration-inactive')
				->with([
					'center' => $this->center,
				]);
		}
    }
}
