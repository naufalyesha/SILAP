<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AdminController extends Controller
{
    function admin()
    {
        return view('admin/dashboard');
    }

    // public function updateProfileAdmin(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'alamat' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //     ]);

    //     $user = Auth::user();
    //     $user->update([
    //         'nama' => $request->nama,
    //         'alamat' => $request->alamat,
    //         'phone' => $request->phone,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'user' => $user,
    //     ]);
    // }

    // Melihat Daftar Vendor (Read) //done
    public function indexVendorManagement()
    {
        // Mengambil semua user dengan role 'vendor'
        $vendors = User::where('role', 'vendor')->get();

        // Mengirim data ke view
        return view('admin.list_vendor.index', compact('vendors'));
    }

    // Melakukan Ban ke Vendor (Update)
    public function banVendor(Request $request)
    {
        $vendor = User::find($request->vendorId);
        if ($vendor) {
            $vendor->banned = true;
            $vendor->ban_reason = $request->reason; // Menyimpan alasan ban
            $vendor->save();
            return redirect()->route('admin.vendor-management')->with('success', 'Vendor berhasil diban');
        }
        return redirect()->route('admin.vendor-management')->with('error', 'Vendor tidak ditemukan');
    }
    //UnBan Vendor
    public function unbanVendor(Request $request)
    {
        $vendor = User::find($request->vendorId);
        if ($vendor) {
            $vendor->banned = false;
            $vendor->ban_reason = null; // Menghapus alasan ban
            $vendor->save();
            return redirect()->route('admin.vendor-management')->with('success', 'Ban vendor berhasil dihapus');
        }
        return redirect()->route('admin.vendor-management')->with('error', 'Vendor tidak ditemukan');
    }
}
