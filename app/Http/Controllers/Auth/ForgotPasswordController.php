<?php

namespace App\Http\Controllers\Auth;

use App\Helper;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        Mail::send('auth.email-forget-password', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')
                            ->where([
                                'email' => $request->email,
                                'token' => $request->token
                            ])
                            ->first();
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }
        User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);
        $user = User::where('email', $request->email)->first();
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        if ($user->role==1) {
            return redirect('/auth/admin/sign-in')->with('message', 'Your password has been changed!');
        } else {
            return redirect('/member/sign-in')->with('message', 'Your password has been changed!');
        }
    }
}
