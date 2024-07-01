<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function index(){
        return view ('auth.login');
    }

    public function login_process(Request $request){
        $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        $data = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if(Auth::attempt($data)){
            if(Auth::user()->role == 'admin'){
                return redirect('admin/admin1');
            } elseif(Auth::user()->role == 'vendor'){
                return redirect('admin/vendor');
            } elseif(Auth::user()->role == 'customer'){
                return redirect('admin/customer');
            }
        }else{
            return redirect()->route('login')->with('failed', 'Email atau Password salah!')->withInput();
        }
    }

    public function register(){
        return view ('auth.register');
    }

    public function register_process(Request $request) {
        // Validasi input
        $validatedData = $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6',
        ]);
    
        try {
            $data['name'] = $validatedData['nama'];
            $data['email'] = $validatedData['email'];
            $data['password'] = Hash::make($validatedData['password']);
    
            User::create($data);
            return redirect()->route('login')->with('success', 'User registered successfully. Please login.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed, please try again']);
        }
    }

    public function showLoginForm() {
        return view('auth.login');
    }
    
    function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
