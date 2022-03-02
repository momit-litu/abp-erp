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
    public function __construct($title, $body)
    {
        $this->title 	= $title;
		$this->body 	= $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->view('view.name');
        $settings 	  = Setting::first();
        dd($settings);
        return $this->subject($this->title.' - '.$settings['company_name'])
            ->markdown('mails.bulk-email')
            ->with([
                'body' => $this->body,
                'settings' => $settings,
            ]);
			
    }
}
