<?php

namespace App\Providers;

use App\Providers\StudentRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StudentRegisteredNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StudentRegistered  $event
     * @return void
     */
    public function handle(StudentRegistered $event)
    {
        //
    }
}
