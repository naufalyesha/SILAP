<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class ContactController extends Controller
{
    // Melihat Pengaduan dari User (Read)
    public function indexResponseUser()
    {
        $messages = Message::whereHas('user', function ($query) {
            $query->where('role', 'customer');
        })->latest()->paginate(10);

        return view('admin/response/indexUser', compact('messages'));
    }
    

    // Melihat Pengaduan dari Vendor (Read)
    public function indexResponseVendor()
    {
        $messages = Message::whereHas('user', function ($query) {
            $query->where('role', 'vendor');
        })->latest()->paginate(10);

        return view('admin/response/indexVendor', compact('messages'));
    }

    public function index()
    {
        $admin = User::where('role', 'admin')->first(); // Mengambil user dengan peran admin
        return view('contact', compact('admin'));
    }

    public function contact_process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Dapatkan user yang mengirim pesan
        $user = User::where('email', $request->email)->first();

        // Simpan pesan dalam database
        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'user_id' => $user ? $user->id : null, // Menyimpan user_id jika ada
        ]);
        // dd($request);

        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function deleteResponseVendor(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.response-vendor')->with('success', 'Pesan berhasil dihapus.');
    }
}

