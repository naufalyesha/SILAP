<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        
        $transaction = Transaction::where('id', $request->transaction_id)->first();

        if ($transaction) {
            $transaction->status = $request->status;
            $schedule = Schedule::where('id', $transaction->schedule_id)->first();

            if ($schedule) {
                if ($request->status == 'success') {
                    $schedule->status = 1; // Terpesan
                } else if (in_array($request->status, ['expire', 'cancel', 'deny', 'failed', 'gagal'])) {
                    $schedule->status = 0; // Tersedia
                    $transaction->status = 'gagal'; // Gagal
                }
                $schedule->save();
            }

            $transaction->save();
        }

        return response()->json([
            'message' => 'Status updated successfully',
            'schedule_status' => $schedule->status,
            'transaction_status' => $transaction->status
        ]);
    }
}
