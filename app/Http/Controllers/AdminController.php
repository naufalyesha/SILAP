<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(){
        return view('admin/dashboard');
    }
    function admin1(){
        return view('admin/dashboard');
    }
    function vendor(){
        return view('admin/dashboard');
    }
    function customer(){
        return view('admin/dashboard');
    }
}
