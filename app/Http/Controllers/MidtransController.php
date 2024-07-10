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
        // Config::$serverKey = config('midtrans.server_key');
        // Config::$isProduction = config('midtrans.is_production');
        // Config::$isSanitized = config('midtrans.is_sanitized');
        // Config::$is3ds = config('midtrans.is_3ds');

        // $notification = new Notification();

        // $transactionStatus = $notification->transaction_status;
        // $paymentType = $notification->payment_type;
        // $orderId = $notification->order_id;

        // Find the transaction by orderId
        $transaction = Transaction::where('id', $request->transaction_id)->first();

        // if (!$transaction) {
        //     return response()->json(['error' => 'Transaction not found'], 404);
        // }

        // // Update the transaction status based on the status from Midtrans
        // switch ($transactionStatus) {
        //     case 'capture':
        //         if ($paymentType == 'credit_card') {
        //             if ($notification->fraud_status == 'challenge') {
        //                 $transaction->status = 'challenge';
        //             } else {
        //                 $transaction->status = 'success';
        //             }
        //         }
        //         break;
        //     case 'settlement':
        //         $transaction->status = 'success';
        //         break;
        //     case 'pending':
        //         $transaction->status = 'pending';
        //         break;
        //     case 'deny':
        //         $transaction->status = 'failed';
        //         break;
        //     case 'expire':
        //         $transaction->status = 'expired';
        //         break;
        //     case 'cancel':
        //         $transaction->status = 'canceled';
        //         break;
        // }
        $transaction->status = $request->status;
        if ( $request->status == 'success') {
            $schedule = Schedule::where('id', $transaction->schedule_id)->first();
            $schedule->booked = 1;
        $schedule->save();
        }
        // Save the updated transaction status
        $transaction->save();

        return response()->json(['message' => $schedule->booked]);
    }
}
