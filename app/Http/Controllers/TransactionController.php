<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Schedule;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::with(['schedule'])
            ->where('user_id', $user->id)
            ->get();

        return view('user.transaction', compact('transactions'));
    }

    public function create(Request $request)
    {
        // Validate the request data
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'price' => 'required|numeric',
        ]);

        $user = Auth::user();
        $schedule = Schedule::findOrFail($request->schedule_id);
        $price = $schedule->price;

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Create the transaction in the database
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'snap_token' => '',
            'price' => $price,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $schedule->price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->nama,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token received: ' . $snapToken); // Logging token received

            $order = Transaction::findOrFail($transaction->id);
            // Update the transaction with the Snap token
            $order->update([
                'snap_token' => $snapToken,
            ]);

            Log::info('Transaction updated with Snap Token: ' . $snapToken); // Logging after update

            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            // Catch and log the error
            Log::error('Error creating transaction: ' . $e->getMessage());
            return redirect()->route('transactions.index')->with('error', 'Failed to create transaction. Please try again.');
        }
    }


    public function webhook(Request $request)
    {
        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth",
        ])->get("https://api.sandbox.midtrans.com/v2/$request->transaction_id/status");

        $response = json_decode($response->body());

        //Check to db
        $transaction = Transaction::where('id', $response->transaction_id)->firstOrFail();

        if ($transaction->status === 'settlement' || $transaction->status === 'capture') {
            return response()->json('Payment Has Already Processed!');
        }

        if ($response->transaction_status === 'capture') {
            $transaction->status = 'capture';
        } else if ($response->transaction_status === 'settlement') {
            $transaction->status = 'settlement';
        } else if ($response->transaction_status === 'pending') {
            $transaction->status = 'pending';
        } else if ($response->transaction_status === 'deny') {
            $transaction->status = 'deny';
        } else if ($response->transaction_status === 'expire') {
            $transaction->status = 'expire';
        } else if ($response->transaction_status === 'cancel') {
            $transaction->status = 'cancel';
        }
        $transaction->save();

        return response()->json('Success!');
    }
}
