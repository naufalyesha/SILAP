<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Vendor;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Cek apakah user diblokir
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->banned == 1) {
            if (!empty($user->ban_reason)) {
                return redirect()->route('login')->with('failed', 'Akun Anda telah diblokir: ' . $user->ban_reason . '. Silakan hubungi administrator.');
            } else {
                return redirect()->route('login')->with('failed', 'Akun Anda telah diblokir. Silakan hubungi administrator.');
            }
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect('admin')->with('success', 'Welcome, Admin!');
                case 'vendor':
                    return redirect('vendor')->with('success', 'Welcome, Vendor!');
                case 'customer':
                    return redirect('home')->with('success', 'Welcome, Customer!');
                default:
                    return redirect('/')->with('success', 'Welcome!');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password salah!')->withInput();
        }
    }



    public function register()
    {
        return view('auth.register');
    }

    public function register_process(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'email'     => 'required|email|max:255|unique:users,email',
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string|max:255',
            'phone'     => 'required|string|max:15',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:customer,vendor',
        ]);

        try {
            // Hashing password
            $hashedPassword = Hash::make($validatedData['password']);

            // Simpan data ke dalam tabel users
            $user = User::create([
                'email' => $validatedData['email'],
                'nama' => $validatedData['nama'],
                'alamat' => $validatedData['alamat'],
                'phone' => $validatedData['phone'],
                'password' => $hashedPassword,
                'role' => $validatedData['role'],
            ]);

            return redirect()->route('login')->with('success', 'User registered successfully.');
        } catch (\Exception $e) {
            Log::error('Registration Error: ', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Registration failed, please try again.']);
        }
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
