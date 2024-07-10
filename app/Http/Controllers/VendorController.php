<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Schedule;
use App\Models\Pendapatan;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Pemesanan;
use App\Models\Rating;
use App\Models\MetodePembayaran;


class VendorController extends Controller
{
    // Profile Vendor
    function vendor()
    {
        $user = Auth::user(); // Fetch authenticated user
        return view('vendors.dashboard', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $user = Auth::user();
        $user->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    // Read Lapangan
    public function indexLapangan()
    {
        $user = Auth::user();
        $vendorId = auth()->user()->id;
        $lapangan = Lapangan::where('vendor_id', $vendorId)->latest()->paginate(5);
        return view('lapangan.index', compact('lapangan', 'user'));
    }

    // Menambahkan Lapangan (Create)
    public function createLapangan()
    {
        $user = Auth::user();
        return view('lapangan.create', compact('user'));
    }
    public function storeLapangan(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'map'           => 'nullable|url',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'type'          => 'required|string',
            'description'   => 'required|string',
            'facilities'    => 'nullable|string'
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images'), $photoName);
        } else {
            $photoName = null;
        }

        // Simpan data ke database
        $lapangan = Lapangan::create([
            'name'          => $validatedData['name'],
            'location'      => $validatedData['location'],
            'map'           => $validatedData['map'],
            'photo'         => $photoName,
            'type'          => $validatedData['type'],
            'description'   => $validatedData['description'],
            'facilities'    => $validatedData['facilities'],
            'vendor_id'     => auth()->user()->id, 
        ]);

        // Periksa apakah data berhasil disimpan
        if ($lapangan) {
            Log::info('Lapangan berhasil ditambahkan: ' . $lapangan->id);
        } else {
            Log::error('Gagal menyimpan lapangan.');
        }
        // Redirect ke halaman lapangan dengan pesan sukses
        return redirect()->route('vendor.lapangans')->with('success', 'Lapangan berhasil ditambahkan!');
    }
    // Method untuk menampilkan form edit
    public function editLapangan($id)
    {
        $user = Auth::user();
        $lapangan = Lapangan::findOrFail($id);
        return view('lapangan.edit', compact('lapangan', 'user'));
    }
    // Method untuk mengupdate data
    public function updateLapangan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'map' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|string',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
        ]);

        $lapangan = Lapangan::findOrFail($id);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($lapangan->photo && file_exists(public_path('images/' . $lapangan->photo))) {
                unlink(public_path('images/' . $lapangan->photo));
            }

            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images'), $photoName);
            Log::info('Photo updated: ' . $photoName);
        } else {
            $photoName = $lapangan->photo;
            Log::info('No new photo uploaded.');
        }

        // Update data ke database
        $lapangan->update([
            'name' => $request->name,
            'location' => $request->location,
            'map' => $request->map,
            'photo' => $photoName,
            'type' => $request->type,
            'description' => $request->description,
            'facilities' => $request->facilities,
            'vendor_id' => auth()->user()->id,
        ]);

        // Periksa apakah data berhasil disimpan
        if ($lapangan) {
            Log::info('Lapangan berhasil diupdate: ' . $lapangan->id);
        } else {
            Log::error('Gagal mengupdate lapangan.');
        }

        // Redirect ke halaman lapangan dengan pesan sukses
        return redirect()->route('vendor.lapangans')->with('success', 'Lapangan berhasil diupdate!');
    }
    // Method untuk menghapus data
    public function destroyLapangan($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // Hapus foto dari folder images jika ada
        if ($lapangan->photo && file_exists(public_path('images/' . $lapangan->photo))) {
            unlink(public_path('images/' . $lapangan->photo));
        }

        $lapangan->delete();

        return redirect()->route('vendor.lapangans')->with('success', 'Lapangan berhasil dihapus!');
    }

    // Membuka dan Mengatur Jadwal Lapangan (Create/Update) 
    public function indexSchedule()
    {
        $user = Auth::user();
        $vendorId = auth()->user()->id;
        $schedules = Schedule::where('vendor_id', $vendorId)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('schedules.index', compact('schedules', 'user'));
    }

    public function createSchedule()
    {
        $user = Auth::user();
        $vendorId = auth()->user()->id;
        $lapangans = Lapangan::where('vendor_id', $vendorId)->get();
        return view('schedules.create', compact('lapangans', 'user'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:0',
        ]);

        // Memeriksa apakah ada jadwal lain dalam rentang waktu yang sama
        $existingSchedule = Schedule::where('lapangan_id', $request->lapangan_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->withErrors(['Jadwal sudah ada dalam rentang waktu tersebut.'])->withInput();
        }

        // Simpan data jadwal ke database
        Schedule::create([
            'lapangan_id' => $request->lapangan_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'price' => $request->price,
            'vendor_id' => auth()->user()->id,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function editSchedule($id)
    {
        $user = Auth::user();
        $schedules = Schedule::findOrFail($id); // Ambil data schedule berdasarkan ID
        $lapangans = Lapangan::all(); //Ambil semua data lapangan
        return view('schedules.edit', compact('schedules', 'lapangans', 'user'));
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        // Validasi data yang dikirim dari form edit
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'price' => 'required|numeric|min:0',
        ]);

        // Periksa apakah user yang sedang login adalah vendor dari lapangan yang diubah
        if ($schedule->lapangan->vendor_id !== auth()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Memeriksa apakah ada jadwal lain dalam rentang waktu yang sama
        $existingSchedule = Schedule::where('lapangan_id', $request->lapangan_id)
            ->where('date', $request->date)
            ->where('id', '!=', $id)  // Mengecualikan jadwal yang sedang diupdate
            ->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
            })
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->withErrors(['Jadwal sudah ada dalam rentang waktu tersebut.'])->withInput();
        }

        // Update data schedule berdasarkan input dari form
        $schedule->lapangan_id = $request->lapangan_id;
        $schedule->date = $request->date;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->price = $request->price;
        $schedule->save();

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }


    // Menambahkan Metode Pembayaran (Create)
    // public function addMetodePembayaran(Request $request)
    // {
    //     $metodePembayaran = new MetodePembayaran();
    //     $metodePembayaran->vendor_id = $request->user()->id;
    //     $metodePembayaran->metode = $request->metode;
    //     $metodePembayaran->save();

    //     return response()->json(['message' => 'Metode pembayaran berhasil ditambahkan'], 201);
    // }

    // Menjawab Ulasan (Create/Read/Update/Delete)
    public function replyUlasan(Request $request, $ulasan_id)
    {
        $rating = Rating::find($ulasan_id);
        if (!$rating) {
            return response()->json(['message' => 'Ulasan tidak ditemukan'], 404);
        }

        $rating->jawaban = $request->jawaban;
        $rating->save();

        return response()->json(['message' => 'Jawaban ulasan berhasil ditambahkan'], 201);
    }

    public function getUlasan()
    {
        $ulasan = Rating::where('vendor_id', auth()->user()->id)->get();
        return response()->json($ulasan, 200);
    }

    public function updateUlasan(Request $request, $ulasan_id)
    {
        $rating = Rating::find($ulasan_id);
        if (!$rating) {
            return response()->json(['message' => 'Ulasan tidak ditemukan'], 404);
        }

        $rating->jawaban = $request->jawaban;
        $rating->save();

        return response()->json(['message' => 'Jawaban ulasan berhasil diupdate'], 200);
    }

    public function deleteUlasan($ulasan_id)
    {
        $rating = Rating::find($ulasan_id);
        if (!$rating) {
            return response()->json(['message' => 'Ulasan tidak ditemukan'], 404);
        }

        $rating->jawaban = null;
        $rating->save();

        return response()->json(['message' => 'Jawaban ulasan berhasil dihapus'], 200);
    }

    // Melihat Pendapatan atau Laporan Keuangan (Read) (belom)
    public function indexPendapatan()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $reports = Pendapatan::where('user_id', $userId)->orderBy('report_date', 'asc')->get();

        $totalRevenue = $reports->sum('revenue');
        $totalOperationalCost = $reports->sum('operational_cost');
        $totalMaintenanceCost = $reports->sum('maintenance_cost');
        $totalOtherCost = $reports->sum('other_cost');
        $totalCost = $totalOperationalCost + $totalMaintenanceCost + $totalOtherCost;
        $netProfit = $totalRevenue - $totalCost;
        $totalReports = $reports->count(); // Jumlah total laporan keuangan

        return view('pendapatan.index', compact(
            'reports',
            'totalRevenue',
            'totalOperationalCost',
            'totalMaintenanceCost',
            'totalOtherCost',
            'totalCost',
            'netProfit',
            'totalReports',
            'user'
        ));
    }

    // Melihat Statistik Penggunaan Lapangan (Read)
    public function getStatistikPenggunaan()
    {
        $statistik = Pemesanan::selectRaw('lapangan_id, count(*) as total')
            ->where('vendor_id', auth()->user()->id)
            ->groupBy('lapangan_id')
            ->get();
        return response()->json($statistik, 200);
    }

    // Melihat Daftar Metode Pembayaran (Read)
    public function indexPaymentMethod()
    {
        // $schedules = Schedule::all();
        $user = Auth::user();
        return view('payment_methods.index', compact('user'));
    }

    // Melihat Interaksi dengan User (Read)
    public function indexVendorInteraction()
    {
        // $schedules = Schedule::all();
        $user = Auth::user();
        return view('vendor_interaction.index', compact('user'));
    }
}
