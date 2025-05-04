<?php

namespace App\Console;

use App\Mail\BackupCleanFailMail;
use App\Mail\BackupCleanSuccessMail;
use App\Mail\BackupFailMail;
use App\Mail\BackupSuccessMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup:clean')->daily()->at('01:00')
            ->onFailure(function () {
                Mail::to(config('app.support_mail'))
                    ->cc(config('app.support_mail_cc'))
                    ->send(new BackupCleanFailMail([]));
            })->onSuccess(function () {
                Mail::to(config('app.support_mail'))
                    ->cc(config('app.support_mail_cc'))
                    ->send(new BackupCleanSuccessMail([]));
            });

        $schedule->command('backup:run')->daily()->at('01:30')
            ->onFailure(function () {
                Mail::to(config('app.support_mail'))
                    ->cc(config('app.support_mail_cc'))
                    ->send(new BackupFailMail([]));
            })->onSuccess(function () {
                Mail::to(config('app.support_mail'))
                    ->cc(config('app.support_mail_cc'))
                    ->send(new BackupSuccessMail([]));
            });

        $schedule->command('sitemap:generate')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
