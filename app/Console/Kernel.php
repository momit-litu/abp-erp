<?php

namespace App\Console;

use App\Models\Batch;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            Log::debug('Today:'.date('Y-m-d'));
            $todaysBatches = Batch::where('start_date',date('Y-m-d'));
            foreach($todaysBatches as $batch){
                $batch->running_status = 'Running';
                $batch->save();
                Log::debug('batch status changed :'.$batch->id);
            }
        })->daily()->at('13:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
