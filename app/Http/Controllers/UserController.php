<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lapangan; 
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

        // Ambil data admin
        $admin = User::where('role', 'admin')->first();

        // Kirim data ke view
        return view('welcome', compact('lapangans', 'admin'));
    }

    public function detailLapangan($id)
    {
        // Ambil data dari database
        $lapangan = Lapangan::with('vendor', 'schedules')->findOrFail($id);
        $days = [
            'Min<br>30 Jun', 'Sen<br>1 Jul', 'Sel<br>2 Jul',
            'Rab<br>3 Jul', 'Kam<br>4 Jul', 'Jum<br>5 Jul', 'Sab<br>6 Jul'
        ];

        // Kirim data ke view
        return view('user.detail', compact('lapangan', 'days'));
    }

    // Menyewa Lapangan (Create Pemesanan)
    public function sewaLapangan(Request $request)
    {
        $pemesanan = new Pemesanan();
        $pemesanan->user_id = $request->user()->id;
        $pemesanan->lapangan_id = $request->lapangan_id;
        $pemesanan->tanggal = $request->tanggal;
        $pemesanan->waktu_mulai = $request->waktu_mulai;
        $pemesanan->waktu_selesai = $request->waktu_selesai;
        $pemesanan->status_pembayaran = 'belum_dibayar';
        $pemesanan->save();

        return response()->json(['message' => 'Pemesanan berhasil dilakukan'], 201);
    }

    // Memilih Lapangan (Read)
    public function getLapangan()
    {
        $lapangan = Lapangan::all();
        return response()->json($lapangan, 200);
    }

    // Menentukan Tanggal (Read)
    public function getAvailableDates($lapangan_id)
    {
        $dates = Pemesanan::where('lapangan_id', $lapangan_id)->pluck('tanggal');
        return response()->json($dates, 200);
    }

    // Pembayaran Online (Read)
    public function getPembayaran($pemesanan_id)
    {
        $pemesanan = Pemesanan::find($pemesanan_id);
        if (!$pemesanan) {
            return response()->json(['message' => 'Pemesanan tidak ditemukan'], 404);
        }
        return response()->json(['status_pembayaran' => $pemesanan->status_pembayaran], 200);
    }

    // Pencarian dan Filter Lapangan (Read)
    public function searchLapangan(Request $request)
    {
        $query = Lapangan::query();

        if ($request->has('lokasi')) {
            $query->where('lokasi', 'LIKE', '%' . $request->lokasi . '%');
        }
        if ($request->has('harga')) {
            $query->where('harga', '<=', $request->harga);
        }
        if ($request->has('fasilitas')) {
            $query->where('fasilitas', 'LIKE', '%' . $request->fasilitas . '%');
        }
        if ($request->has('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        $lapangan = $query->get();
        return response()->json($lapangan, 200);
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

    // Memberikan Rating dan Ulasan (Create)
    public function submitRating(Request $request)
    {
        $rating = new Rating();
        $rating->user_id = $request->user()->id;
        $rating->lapangan_id = $request->lapangan_id;
        $rating->rating = $request->rating;
        $rating->ulasan = $request->ulasan;
        $rating->save();

        return response()->json(['message' => 'Rating dan ulasan berhasil dikirim'], 201);
    }

    // Membuat Pengaduan (Create)
    public function submitPengaduan(Request $request)
    {
        $pengaduan = new Pengaduan();
        $pengaduan->user_id = $request->user()->id;
        $pengaduan->lapangan_id = $request->lapangan_id;
        $pengaduan->deskripsi = $request->deskripsi;
        $pengaduan->save();

        return response()->json(['message' => 'Pengaduan berhasil dikirim'], 201);
    }
}
