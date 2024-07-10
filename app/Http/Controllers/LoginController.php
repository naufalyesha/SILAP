<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ResetPasswordTokens;
use App\Models\Vendor;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect('admin')->with('success', 'Welcome back, Admin!');
                case 'vendor':
                    return redirect('vendor')->with('success', 'Welcome back, Vendor!');
                case 'customer':
                    return redirect('home')->with('success', 'Welcome back, Customer!');
                default:
                    return redirect('/')->with('success', 'Welcome back!');
            }
        }

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

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordAct(Request $request)
    {
        $customMessage = [
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email tidak valid',
            'email.exists' => 'email tidak terdaftar di database',
        ];
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], $customMessage);

        $token = Str::random(60);

        ResetPasswordTokens::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

        return redirect()->route('forgot-password')->with('success', 'Password reset link has been sent!');
    }

    public function forgotPasswordValidate(Request $request, $token)
    {
        $getToken = ResetPasswordTokens::where('token', $token)->first();

        if (!$getToken) {
            return redirect()->route('login')->with('failed', 'Token tidak valid!');
        }
        return view('auth.validasi-token', compact('token'));
    }

    public function forgotPasswordValidateAct(Request $request)
    {
        $customMessage = [
            'password.required' => 'Password tidak boleh kosong!',
            'password.min'      => 'Password minimal 6 Karakter',
        ];

        $request->validate([
            'password' => 'required|min:6',
        ], $customMessage);

        $email = ResetPasswordTokens::where('token', $request->token)->first();
        if (!$email) {
            return redirect()->route('login')->with('failed', 'Token tidak valid!');
        }

        $user = User::where('email', $email->email)->first();
        // dd($user->email);
        if (!$user) {
            return redirect()->route('login')->with('failed', 'Email tidak terdaftar di database');
        }

        try {
            DB::table('users')->where('email', $user->email)->update(['password' => Hash::make($request->password)]);

            $email->delete();

            return redirect()->route('login')->with('success', 'Password berhasil direset');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('failed', 'Password reset failed. Please try again.');
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
