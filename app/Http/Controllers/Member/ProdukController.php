<?php

namespace App\Http\Controllers\Member;

use Exception;
use App\Helper;
use Carbon\Carbon;
use App\Models\MasterBank;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterRasHewan;
use App\Models\ProdukAsuransi;
use App\Models\PembelianProduk;
use App\Models\MasterJenisHewan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = ProdukAsuransi::select('id','nama_produk')->get();
        $jenis = MasterJenisHewan::select('id','nama')->get();
        return view('member.beli-produk',[
            'title'=>'Pembelian',
            'produks'=>$produk,
            'jeniss'=>$jenis
        ]);
    }

    public function get_ras($id)
    {
        $ras = MasterRasHewan::select('id','nama_ras','harga_hewan')->where('jenis_hewan_id',$id)->get();
            if ($ras) {
                return response()->json([
                    'status'=>200,
                    'ras'=>$ras
                ]);
            } else {
                return response()->json([
                    'status'=>404,
                    'message'=>'Data tidak ditemukan'
                ],404);
            }
    }

    public function pembelian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'nama_hewan' => 'required',
            'jangka_waktu' => 'required',
            'nama_pemilik' => 'required',
            'bobot' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'ras_hewan' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg|max:2048',
        ],
        [
            '*.required' => 'Wajib diisi!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $foto = $request->file('foto')->store('public/data-pembelian/foto-hewan/member_'.Str::slug(auth()->user()->member->nama_lengkap));
                $ras = MasterRasHewan::select('harga_hewan','persen_per_umur')->where('id',$request->ras_hewan)->first();
                $umur = Carbon::parse($request->tgl_lahir)->age;
                $dasar_premi = $ras->harga_hewan*(5/100);
                $total_premi = $dasar_premi + ($dasar_premi*(($ras->persen_per_umur*$umur)/100));
                PembelianProduk::create([
                    'produk_id'=>$request->produk_id,
                    'nama_hewan'=>$request->nama_hewan,
                    'nama_pemilik'=>$request->nama_pemilik,
                    'tgl_lahir_hewan'=>$request->tgl_lahir,
                    'member_id'=>auth()->user()->member->id,
                    'berat_badan_kg'=>$request->bobot,
                    'jenis_kelamin_hewan'=>$request->jenis_kelamin,
                    'ras_hewan_id'=>$request->ras_hewan,
                    'biaya_pendaftaran'=>138000,
                    'harga_dasar_premi'=>$total_premi,
                    'tgl_daftar_asuransi'=>Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                    'foto'=>$foto,
                    'status'=>1,
                    'jangka_waktu'=>$request->jangka_waktu,
                    'pay_status'=>false
                ]);

                $produk = ProdukAsuransi::select('nama_produk')->find($request->produk_id);
                DB::commit();
                Helper::createUserLog("Berhasil melakukan pembelian produk ".$produk->nama_produk, auth()->user()->id, 'Pembelian Produk');
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil melakukan pembelian'
                ]);
            } catch(Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal melakukan pembelian produk ".$produk->nama_produk, auth()->user()->id, 'Pembelian Produk');
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function form_bayar()
    {
        $notpayed = PembelianProduk::with('produk','ras_hewan.jenis_hewan')
                    ->select('id','harga_dasar_premi','biaya_pendaftaran','produk_id','ras_hewan_id')
                    ->where(function($q){
                                $q->where('pay_status',false)
                                    ->where('member_id',auth()->user()->member->id);
                            })->latest()->first();
        $bank = MasterBank::with('nomor_rekening_bank')->get();
        return view('member.form-pembayaran',[
            'title'=>'Form Pembayaran',
            'notpayed'=>$notpayed,
            'banks'=>$bank
        ]);
    }

    public function form_bayar_cart($id)
    {
        $notpayed = PembelianProduk::with('produk','ras_hewan.jenis_hewan')
                    ->select('id','harga_dasar_premi','biaya_pendaftaran','produk_id','ras_hewan_id')
                    ->find($id);
        $bank = MasterBank::with('nomor_rekening_bank')->get();
        return view('member.form-pembayaran',[
            'title'=>'Form Pembayaran',
            'notpayed'=>$notpayed,
            'banks'=>$bank
        ]);
    }

    public function konfirmasi_bayar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti' => 'required|mimes:png,jpg,jpeg|max:2048',
            'pembelian_id' => 'required',
        ],['*.required' => 'Wajib diisi!']);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                $pembelian = PembelianProduk::find($request->pembelian_id);
                $bukti = $request->file('bukti')->store('public/data-pembelian/bukti-bayar/member_'.Str::slug(auth()->user()->member->nama_lengkap));
                $pembelian->bukti_bayar = $bukti;
                $pembelian->pay_status = true;
                $pembelian->save();
                DB::commit();
                Helper::createUserLog("Berhasil konfirmasi pembayaran", auth()->user()->id, 'Pembelian Produk');
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil melakukan konfirmasi'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal konfirmasi pembayaran", auth()->user()->id, 'Pembelian Produk');
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }
}
