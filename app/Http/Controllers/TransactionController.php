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
        $transactions = Transaction::with(['schedule.lapangan', 'schedule.vendor'])
            ->where('user_id', $user->id)
            ->get();
        return view('user.transaction', compact('transactions'));
    }

    public function create(Request $request)
    {
        // Validasi data request
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

        // Buat transaksi di database
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
                'first_name' => $user->nama,
                'email' => $user->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token diterima: ' . $snapToken);

            $order = Transaction::findOrFail($transaction->id);
            // Update transaksi dengan Snap token
            $order->update([
                'snap_token' => $snapToken,
            ]);

            Log::info('Transaksi diperbarui dengan Snap Token: ' . $snapToken);

            return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Dibuat!');
        } catch (\Exception $e) {
            // Tangani dan log kesalahan
            Log::error('Error membuat transaksi: ' . $e->getMessage());
            return redirect()->route('transactions.index')->with('error', 'Gagal membuat Transaksi. Coba Lagi.');
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
            return response()->json('Pembayaran Telah Diproses!');
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

        if ($transaction->status === 'settlement' || $transaction->status === 'capture') {
            return response()->json('Pembayaran Telah Diproses!');
        }

        // if ($response->transaction_status === 'capture') {
        //     $transaction->status = 'capture';
        // } else if ($response->transaction_status === 'settlement') {
        //     $transaction->status = 'settlement';
        // } else if ($response->transaction_status === 'pending') {
        //     $transaction->status = 'pending';
        // } else if ($response->transaction_status === 'deny') {
        //     $transaction->status = 'deny';
        // } else if ($response->transaction_status === 'expire') {
        //     $transaction->status = 'expire';
        // } else if ($response->transaction_status === 'cancel') {
        //     $transaction->status = 'cancel';
        // }
        // $transaction->save();

        return response()->json('Sukses!');
    }
}
