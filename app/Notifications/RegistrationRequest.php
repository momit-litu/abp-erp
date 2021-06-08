<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Registration;

class RegistrationRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
		//dd($notifiable);
        return [/*'mail',*/'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
	
	public function toDatabase($notifiable)
    {
		if($this->registration->approval_status == 'Requested'){
			$messageType = "Success";
			$message	 = "A new registration request waiting for approval from ".$this->registration->center->name;
		}
		else if($this->registration->approval_status == 'Approved'){
			$messageType = "Success";
			$message	 = "Registration #".$this->registration->registration_no." has been approved by Edupro";
		}
		else if($this->registration->approval_status == 'Rejected'){
			$messageType = "Fail";
			$message	 = "Registration #".$this->registration->registration_no." has been rejected by Edupro";
		}
		//echo $messageType;die;
        return [
			'type'		=>	$messageType,
			'Message'	=>	$message
		];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
