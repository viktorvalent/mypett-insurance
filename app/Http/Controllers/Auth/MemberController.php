<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.login', [
            'title'=>'Sign In | Mypett Insurance'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ],
        [
            'email.required' => 'Email wajib diisi!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            $input = [
                'email' => $request->email,
                'password' => $request->password,
                'role' => 2
            ];
            if(Auth::attempt($input)) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 200,
                    'message' => 'Login Berhasil'
                ]);
            } else {
                return response()->json([
                    'status' => 422,
                    'message' => 'Email atau password tidak valid!'
                ], 422);
            }
        }
    }

    public function registration(Request $request)
    {
        $this->validate(request(), [
            'regname' => 'required',
            'regemail' => 'required|email',
            'regpassword' => 'required|min:6',
            'regconfirmpassword' => 'required|min:6|same:regpassword'
        ],[
            '*.same' => 'Password dan Confirm Password harus sama',
            '*.min' =>'Password minimal 6 Karakter',
            '*.required' => 'Field tidak boleh kosong'
        ]);

        $user = User::create([
            'username' => $request->regname,
            'email' => $request->regemail,
            'password' => Hash::make($request->regpassword),
            'role' => 2
        ]);

        if (!$user) {
            return back()->with('error','Gagal Sign Up');
        }
        return redirect()->route('sign-in.member')->with('success','Berhasil sign-up');;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('sign-in.member');
    }
}
