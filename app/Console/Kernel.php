<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Transaction;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $expiredTransactions = Transaction::where('status', 'pending')
                ->where('created_at', '<=', now()->subMinutes(10))
                ->get();

            foreach ($expiredTransactions as $transaction) {
                $transaction->status = 'gagal';
                $transaction->save();

                $schedule = Schedule::find($transaction->schedule_id);
                if ($schedule) {
                    $schedule->status = 0; // Tersedia
                    $schedule->save();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
