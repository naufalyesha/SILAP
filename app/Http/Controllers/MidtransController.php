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
        // Uncomment these lines if you need to configure Midtrans
        // Config::$serverKey = config('midtrans.server_key');
        // Config::$isProduction = config('midtrans.is_production');
        // Config::$isSanitized = config('midtrans.is_sanitized');
        // Config::$is3ds = config('midtrans.is_3ds');

        // Uncomment and use this line if you need to process the notification from Midtrans
        // $notification = new Notification();

        // $transactionStatus = $notification->transaction_status;
        // $paymentType = $notification->payment_type;
        // $orderId = $notification->order_id;

        // Find the transaction by orderId
        $transaction = Transaction::where('id', $request->transaction_id)->first();

        // if (!$transaction) {
        //     return response()->json(['error' => 'Transaction not found'], 404);
        // }

        // Update the transaction status based on the status from the request
        $transaction->status = $request->status;
        $schedule = Schedule::where('id', $transaction->schedule_id)->first();

        // if (!$schedule) {
        //     return response()->json(['error' => 'Schedule not found'], 404);
        // }

        // Update schedule status based on transaction status
        if ($request->status == 'success') {
            $schedule->status = 1; // Set status to 'booked'
        } 
        // elseif ($request->status == 'failed') {
        //     $schedule->status = 0; // Set status to 'available'
        //     $transaction->status = 'gagal'; // Set transaction status to 'failed'
        // }

        $schedule->save();
        $transaction->save();

        return response()->json(['message' => 'Status updated successfully', 'schedule_status' => $schedule->status, 'transaction_status' => $transaction->status]);
    }
}
