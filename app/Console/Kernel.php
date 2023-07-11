<?php

namespace App\Console;

use App\Console\Commands\CreateSquadXml;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $url = "https://discord.com/api/webhooks/1128361784181522614/7cZaCYbknWq30Wrnwp7RQm_NCMj7g5VCBettdJ-G8mtIyRG0jfnUIW_14WZlSmBgYoY-";
        $headers = [ 'Content-Type: application/json; charset=utf-8' ];
        $POST = [ 'username' => 'Testing BOT', 'content' => 'Testing message' ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
        $response   = curl_exec($ch);
        $schedule->command(CreateSquadXml::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
