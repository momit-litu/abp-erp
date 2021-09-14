<?php
namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class studentEnrollmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($studentEnrollment)
    {
        $this->studentEnrollment 	= $studentEnrollment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->view('view.name');
      
       $settings = Setting::first();
       //dd($settings);
        return $this->subject($settings['company_name'].' course enrollment confirmation')
            ->markdown('mails.student-enrollment')
            ->with([
                'studentEnrollment' => $this->studentEnrollment,
                'settings' => $settings
            ]);
    }
}
