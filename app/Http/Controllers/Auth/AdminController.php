<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login',['title'=>'Sign In | Mypett Insurance']);
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
                'role' => 1
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

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_pass' => 'required|min:6',
            'confirm_new_pass' => 'required|min:6|same:new_pass',
        ],
        [
            '*.required' => 'Tidak boleh kosong!',
            '*.min' => 'Minimal 6 karakter!',
            '*.same'=>'Password baru harus sama!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            DB::beginTransaction();
            $data = User::find($request->id);
            try {
                if ($request->new_pass!=$request->confirm_new_pass) {
                    return response()->json([
                        'status'=>404,
                        'message'=>'Password tidak sama!'
                    ],404);
                } else {
                    $data->update(['password'=>Hash::make($request->confirm_new_pass)]);
                    Helper::createUserLog("Berhasil mengubah password admin ", auth()->user()->id, 'Admin Profile');
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah password'
                    ]);
                }
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal mengubah password", auth()->user()->id, 'Admin Profile');
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('sign-in.admin');
    }
}
