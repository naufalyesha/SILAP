<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'owner_id' => 'required|integer|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Buat vendor baru
        $vendor = new Vendor();
        $vendor->owner_id = $request->owner_id;
        $vendor->nama = $request->nama;
        $vendor->alamat = $request->alamat;
        $vendor->save();

        // Kembalikan respon sukses
        return redirect()->route('admin')->with('success', 'Vendor successfully created.');
    }
}
