<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Transaction;
use App\Models\Pemesanan; //Belom
use App\Models\Rating; //Belom
use App\Models\Pengaduan; //Belom

class UserController extends Controller
{
    function customer()
    {
        // Ambil data lapangans dari database dengan paginasi, hanya lapangan yang vendornya tidak diblokir
        $lapangans = Lapangan::with(['schedules' => function ($query) {
            $query->orderBy('price', 'asc');
        }])
            ->whereHas('vendor', function ($query) {
                $query->where('banned', 0);
            })
            ->latest()
            ->paginate(15);

        // Ambil data lokasi unik dari lapangans
        $locations = Lapangan::select('location')->distinct()->get();

        // Ambil data admin
        $admin = User::where('role', 'admin')->first();

        // Kirim data ke view
        return view('welcome', compact('lapangans', 'admin', 'locations'));
    }

    public function detailLapangan($id)
    {
        $lapangan = Lapangan::with('vendor', 'schedules.vendor')->findOrFail($id);
        return view('user.detail', compact('lapangan'));
    }

    // Memberikan Rating dan Ulasan (Create)
    public function submitRating(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        Rating::create([
            'user_id' => Auth::id(),
            'field_id' => $request->field_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Thank you for your rating!');
    }

    // Pembatalan Pemesanan (Delete)
    public function cancelPemesanan($pemesanan_id)
    {
        $pemesanan = Pemesanan::find($pemesanan_id);
        if (!$pemesanan) {
            return response()->json(['message' => 'Pemesanan tidak ditemukan'], 404);
        }

        $tanggal_pemesanan = \Carbon\Carbon::parse($pemesanan->tanggal);
        if ($tanggal_pemesanan->diffInDays(\Carbon\Carbon::now()) < 2) {
            return response()->json(['message' => 'Pembatalan hanya bisa dilakukan maksimal H-2 sebelum tanggal pemesanan'], 400);
        }

        $pemesanan->delete();
        return response()->json(['message' => 'Pemesanan berhasil dibatalkan'], 200);
    }
}
