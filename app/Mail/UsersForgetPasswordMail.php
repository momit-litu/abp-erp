<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;



    /**

     * Create a new message instance.

     *

     * @return void

     */

    public function __construct($details)

    {

        $this->details = $details;

    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = Setting::first();
        return $this->subject('Password Recovery - '.$settings['company_name'])
            ->markdown('mails.forget-password-mail')
            ->with([
                'details' => $this->details,
                'settings' => $settings,
            ]);
    }
}
