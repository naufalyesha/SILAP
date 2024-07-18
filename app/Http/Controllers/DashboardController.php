<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function vendor()
    {
        $user = Auth::user();

        // Pastikan user yang login adalah vendor
        if ($user->role !== 'vendor') {
            abort(403, 'Unauthorized action.');
        }

        $vendorId = $user->id; // Asumsikan user ID adalah vendor ID

        $totalEarnings = Transaction::whereHas('schedule', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->where('status', 'settlement')->sum('price');

        $totalTransactions = Transaction::whereHas('schedule', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->count();

        $transactionStatuses = Transaction::select('status', DB::raw('count(*) as total'))
            ->whereHas('schedule', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        $monthlyEarnings = Transaction::selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->whereHas('schedule', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->where('status', 'settlement')
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        $monthlyTransactions = Transaction::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereHas('schedule', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        $pendingTransactions = Transaction::whereHas('schedule', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->where('status', 'pending')->get();

        $recentTransactions = Transaction::whereHas('schedule', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->orderBy('created_at', 'desc')->take(10)->get();

        $data = [
            'totalEarnings' => $totalEarnings,
            'totalTransactions' => $totalTransactions,
            'transactionStatuses' => $transactionStatuses,
            'monthlyEarnings' => $monthlyEarnings,
            'monthlyTransactions' => $monthlyTransactions,
            'pendingTransactions' => $pendingTransactions,
            'recentTransactions' => $recentTransactions
        ];

        return view('vendors.dashboard', $data);
    }

    public function admin()
    {
        // Menghitung jumlah customer dan vendor
        $customerCount = User::where('role', 'customer')->count();
        $vendorCount = User::where('role', 'vendor')->count();

        // Mendapatkan 10 vendor dengan lapangan terbanyak
        $topVendors = User::where('role', 'vendor')
            ->withCount('lapangans')
            ->orderBy('lapangans_count', 'desc')
            ->take(10)
            ->get();

        return view('admin/dashboard', compact('customerCount', 'vendorCount', 'topVendors'));
    }
}
