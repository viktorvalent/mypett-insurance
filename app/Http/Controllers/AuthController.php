<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('membership.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email:dns'],
            'password' => ['required','min:6'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } else {
            return back()->with('loginError','Email dan Password tidak valid');
        }

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirmpassword' => 'required|same:password'
        ]);

        try {
            $data = new User();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->save();

            if ($data) {
                return back();
            } else {
                return back()->with('regError','Registrasi Gagal');
            }
        } catch (Exception $e) {
            echo $e;
        }

    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('indexs');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
