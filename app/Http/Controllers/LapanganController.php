<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\User;
use App\Models\Schedule;

class LapanganController extends Controller
{
    // Read Lapangan di User
    public function readLapangan()
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

    public function search(Request $request)
    {
        $name = $request->input('name');
        $location = $request->input('location');
        $sport = $request->input('sport');

        $query = Lapangan::with('schedules')
            ->whereHas('vendor', function ($query) {
                $query->where('banned', 0);
            });

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($location) {
            $query->where('location', 'like', '%' . $location . '%');
        }

        if ($sport) {
            $query->where('type', 'like', '%' . $sport . '%');
        }

        $lapangans = $query->get();

        if ($lapangans->isEmpty()) {
            return response()->json(['message' => 'No venues found or the vendor is banned'], 404);
        }

        return response()->json($lapangans);
    }
}
