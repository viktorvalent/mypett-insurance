<?php

namespace App\Http\Controllers\Member;

use Exception;
use App\Helper;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KlaimAsuransi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KonfirmasiKlaimAsuransi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KlaimAsuransiController extends Controller
{
    public $title = 'Klaim Asuransi Member';
    public function klaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal_rs' => 'required|numeric',
            'nominal_obat' => 'required|numeric',
            'nominal_dokter' => 'required|numeric',
            'ket' => 'required',
            'member_id' => 'required',
            'polis' => 'required',
            'bukti' => 'required|mimes:png,jpg,jpeg|max:2048',
            'resep' => 'required|mimes:png,jpg,jpeg|max:2048',
            'diagnosa' => 'required|mimes:png,jpg,jpeg|max:2048',
        ],
        [
            '*.required' => 'Tidak boleh kosong!',
            '*.numeric' => 'Harus angka!',
            '*.mimes' => 'Harus format: jpg,jpeg,png!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $bukti = $request->file('bukti')->store('public/data-klaim/bukti_bayar_'.Str::slug(auth()->user()->member->nama_lengkap));
                $resep = $request->file('resep')->store('public/data-klaim/resep_obat_'.Str::slug(auth()->user()->member->nama_lengkap));
                $diagnosa = $request->file('diagnosa')->store('public/data-klaim/diagnosa_dokter_'.Str::slug(auth()->user()->member->nama_lengkap));
                KlaimAsuransi::create([
                    'member_id'=>$request->member_id,
                    'polis_id'=>$request->polis,
                    'nominal_bayar_rs'=>$request->nominal_rs,
                    'nominal_bayar_dokter'=>$request->nominal_dokter,
                    'nominal_bayar_obat'=>$request->nominal_obat,
                    'keterangan_klaim'=>$request->ket,
                    'tgl_klaim'=>Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                    'foto_bukti_bayar'=>$bukti,
                    'foto_resep_obat'=>$resep,
                    'foto_diagnosa_dokter'=>$diagnosa,
                    'status_klaim'=>1
                ]);

                DB::commit();
                Helper::createUserLog("Berhasil melakukan klaim", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil melakukan klaim'
                ]);
            } catch(Exception $e) {
                Helper::createUserLog("Gagal melakukan klaim", auth()->user()->id, $this->title);
                DB::rollBack();
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function revisi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal_rs' => 'required|numeric',
            'nominal_obat' => 'required|numeric',
            'nominal_dokter' => 'required|numeric',
            'ket' => 'required',
            'polis' => 'required'
        ],
        [
            '*.required' => 'Tidak boleh kosong!',
            '*.numeric' => 'Harus angka!',
            '*.mimes' => 'Harus format: jpg,jpeg,png!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $data = KlaimAsuransi::find($request->klaim_id);

                if ($request->hasFile('bukti')) {
                    $delete_bukti = Storage::delete($data->foto_bukti_bayar);

                    if ($delete_bukti) {
                        $bukti = $request->file('bukti')->store('public/data-klaim/bukti_bayar_'.Str::slug(auth()->user()->member->nama_lengkap));
                        $data->update(['foto_bukti_bayar'=>$bukti]);
                    }
                }
                if ($request->hasFile('resep')) {
                    $delete_resep = Storage::delete($data->foto_resep_obat);
                    if ($delete_resep) {
                        $resep = $request->file('resep')->store('public/data-klaim/resep_obat_'.Str::slug(auth()->user()->member->nama_lengkap));
                        $data->update(['foto_resep_obat'=>$resep]);
                    }
                }
                if ($request->hasFile('diagnosa')) {
                    $delete_dokter = Storage::delete($data->foto_diagnosa_dokter);
                    if ($delete_dokter) {
                        $diagnosa = $request->file('diagnosa')->store('public/data-klaim/diagnosa_dokter_'.Str::slug(auth()->user()->member->nama_lengkap));
                        $data->update(['foto_diagnosa_dokter'=>$diagnosa]);
                    }
                }
                $data->update([
                    'polis_id'=>$request->polis,
                    'nominal_bayar_rs'=>$request->nominal_rs,
                    'nominal_bayar_dokter'=>$request->nominal_dokter,
                    'nominal_bayar_obat'=>$request->nominal_obat,
                    'keterangan_klaim'=>$request->ket,
                    'status_klaim'=>1
                ]);
                DB::commit();
                Helper::createUserLog("Berhasil melakukan revisi klaim", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil melakukan revisi klaim'
                ]);
            } catch(Exception $e) {
                Helper::createUserLog("Gagal melakukan revisi klaim", auth()->user()->id, $this->title);
                DB::rollBack();
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function accept_detail($id)
    {
        $data = KlaimAsuransi::with('terima_klaim_asuransi','tolak_klaim_asuransi')->select('id')->find($id);
        $cek = false;
        if ($data->terima_klaim_asuransi()->exists()) {
            $cek = true;
            $data->terima_klaim_asuransi->bukti_bayar_klaim = asset(Storage::url($data->terima_klaim_asuransi->bukti_bayar_klaim));
        }
        if ($data) {
            return response()->json([
                'status'=>200,
                'data'=>$data,
                'cek'=>$cek
            ]);
        }
    }

    public function confirm_detail($id)
    {
        $data = KlaimAsuransi::with('limit_confirmation_klaim')->select('id')->find($id);
        if ($data) {
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    public function partial_confirm($id)
    {
        $data = KlaimAsuransi::with('konfirmasi_klaim_asuransi')->select('id','nominal_bayar_rs','nominal_bayar_obat','nominal_bayar_dokter')->find($id);
        if ($data) {
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    public function agree_partial_confirm(Request $request)
    {
        if (!empty($request->klaim_id)){
            try {
                DB::beginTransaction();
                $data = KlaimAsuransi::find($request->klaim_id);
                $data->update([
                    'nominal_disetujui'=>$request->nominal_disetujui,
                    'status_klaim'=>7
                ]);
                DB::commit();
                Helper::createUserLog("Berhasil menyetujui partial confirmation", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menyetujui'
                ]);
            } catch (Exception $e) {
                Helper::createUserLog("Gagal menyetujui partial confirmation", auth()->user()->id, $this->title);
                DB::rollBack();
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function agree_limit_confirm(Request $request)
    {
        if (!empty($request->klaim_id)){
            try {
                DB::beginTransaction();
                $data = KlaimAsuransi::find($request->klaim_id);
                $data->update([
                    'nominal_disetujui'=>$request->nominal_disetujui,
                    'status_klaim'=>7
                ]);
                DB::commit();
                Helper::createUserLog("Berhasil menyetujui partial confirmation", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menyetujui'
                ]);
            } catch (Exception $e) {
                Helper::createUserLog("Gagal menyetujui partial confirmation", auth()->user()->id, $this->title);
                DB::rollBack();
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }
}
