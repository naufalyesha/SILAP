<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Transaction;
use App\Models\Schedule;

class CheckTransactionStatus
{
    public function handle($request, Closure $next)
    {
        $transactions = Transaction::where('status', 'pending')
            ->where('created_at', '<=', now()->subMinutes(10))
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->status = 'gagal';
            $transaction->save();

            $schedule = Schedule::find($transaction->schedule_id);
            if ($schedule) {
                $schedule->status = 0; // Tersedia
                $schedule->save();
            }
        }

        return $next($request);
    }
}
