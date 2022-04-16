<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class bulkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $body, $emailFrom, $customSigneture)
    {
        $this->title 	= $title;
		$this->body 	= $body;
        $this->emailFrom= $emailFrom;
        $this->customSigneture= $customSigneture;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $settings 	  = Setting::first();
        return $this->subject($this->title.' - '.$settings['company_name'])
            ->markdown('mails.bulk-email')
            ->from($this->emailFrom)
            ->with([
                'body'      => $this->body,
                'settings'  => $settings,
                'customSigneture'  => $this->customSigneture,
            ]);
			
    }
}
