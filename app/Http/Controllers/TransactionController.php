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
        Log::info('Memulai create method', $request->all());

        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'price' => 'required|numeric',
        ]);

        Log::info('Validasi berhasil');

        $user = Auth::user();
        Log::info('User authenticated', ['user' => $user->id]);

        $schedule = Schedule::findOrFail($request->schedule_id);
        Log::info('Schedule ditemukan', ['schedule' => $schedule->id]);

        $price = $schedule->price;

        if ($schedule->status != 0) {
            return redirect()->back()->with('error', 'Jadwal sudah dipesan atau menunggu.');
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        Log::info('Konfigurasi Midtrans berhasil');

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'snap_token' => '',
            'price' => $price,
        ]);

        Log::info('Transaksi dibuat', ['transaction' => $transaction->id]);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $schedule->price,
            ],
            'customer_details' => [
                'first_name' => $user->nama,
                'email' => $user->email,
            ],
            'expiry' => [
                'start_time' => date("Y-m-d H:i:s T"),
                'unit' => 'minute',
                'duration' => 10
            ],
        ];

        Log::info('Parameter transaksi disiapkan', $params);

        try {
            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap Token diterima: ' . $snapToken);

            $order = Transaction::findOrFail($transaction->id);
            $order->update([
                'snap_token' => $snapToken,
            ]);

            Log::info('Transaksi diperbarui dengan Snap Token: ' . $snapToken);

            $schedule->status = 2;
            $schedule->save();

            return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Dibuat!');
        } catch (\Exception $e) {
            Log::error('Error membuat transaksi: ' . $e->getMessage());
            return redirect()->route('transactions.index')->with('error', 'Gagal membuat Transaksi. Coba Lagi.');
        }
    }


    public function cancel(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        if ($transaction && $transaction->status == 'menunggu') {
            $transaction->status = 'dibatalkan';
            $transaction->save();
            $transaction->schedule->markAsAvailable();
        }
        return redirect()->route('transactions.index')->with('success', 'Transaksi dibatalkan.');
    }

    public function cancelSuccess(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        if ($transaction && $transaction->status == 'success') {
            $transaction->status = 'dibatalkan';
            $transaction->save();
            $transaction->schedule->markAsAvailable();
        }
        return redirect()->route('transactions.index')->with('success', 'Transaksi dibatalkan.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
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
