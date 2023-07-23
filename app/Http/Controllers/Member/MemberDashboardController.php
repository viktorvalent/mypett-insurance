<?php

namespace App\Http\Controllers\Member;

use Exception;
use App\Helper;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\PolisAsuransi;
use App\Models\PembelianProduk;
use App\Models\MasterBankMember;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KlaimAsuransi;
use App\Models\MasterKabKota;
use App\Models\MasterProvinsi;
use App\Models\PetshopTerdekat;
use App\Models\UserLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MemberDashboardController extends Controller
{
    public $title = 'Member Dashboard';

    public function index()
    {
        $bank = MasterBankMember::select('id','nama')->get();
        $provinsi = MasterProvinsi::select('id','nama')->get();
        if(auth()->user()->member) {
            $member = Member::where('user_id',auth()->user()->id)->first();
        } else {
            $member = null;
        }
        return view('member.profile', [
            'title'=>'Member Profile',
            'banks'=>$bank,
            'member'=>$member,
            'provinsis'=>$provinsi
        ]);
    }

    public function get_kab_kota($id)
    {
        $data = MasterKabKota::select('id','nama')->where('provinsi_id',$id)->get();
        if ($data) {
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'Data tidak ditemukan!'
            ]);
        }
    }

    public function edit($id)
    {
        $bank = MasterBankMember::all();
        $member = Member::with('kab_kota')->find($id);
        $provinsi = MasterProvinsi::select('id','nama')->get();
        $kabkota = MasterKabKota::select('id','nama')->where('provinsi_id','=',$member->kab_kota->provinsi_id)->get();
        return view('member.edit-profile', [
            'title'=>'Edit Member Profile',
            'banks'=>$bank,
            'data'=>$member,
            'provinsis'=>$provinsi,
            'kabkotas'=>$kabkota
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
            'bank' => 'required',
            'rek' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
        ],
        [
            '*.required' => 'Tidak boleh kosong!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $member = Member::find($request->member_id);
                if ($member->no_ktp==$request->nik) {
                    $member->update([
                        'nama_lengkap' => $request->nama,
                        'no_ktp' => $request->nik,
                        'no_hp' => $request->nohp,
                        'alamat' => $request->alamat,
                        'bank_id' => $request->bank,
                        'no_rekening' => $request->rek,
                        'kab_kota_id' => $request->kab_kota,
                    ]);
                    Helper::createUserLog("Berhasil update data member ".$request->nama, auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = Member::where('no_ktp','=',$request->nik)->whereNot('id',$request->member_id)->first();
                    if ($cek) {
                        return response()->json([
                            'status'=>404,
                            'message'=>'No KTP telah digunakan!'
                        ],404);
                    } else {
                        $member->update([
                            'nama_lengkap' => $request->nama,
                            'no_ktp' => $request->nik,
                            'no_hp' => $request->nohp,
                            'alamat' => $request->alamat,
                            'bank_id' => $request->bank,
                            'no_rekening' => $request->rek,
                            'kab_kota_id' => $request->kab_kota,
                        ]);
                        Helper::createUserLog("Berhasil update data member ".$request->nama, auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal update data member ".$request->nama, auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function my_insurance()
    {
        if(auth()->user()->member) {
            $member = Member::where('user_id',auth()->user()->id)->first();
            $pembelian = PembelianProduk::where(function($q)use($member){
                $q->where('member_id',$member->id)
                    ->where('pay_status',true);
            })->latest()->get();
        } else {
            $member = null;
        }

        return view('member.asuransi',[
            'title'=>'My Insurance',
            'member'=>$member,
            'pembelians'=>$pembelian
        ]);
    }

    public function klaim()
    {
        $member = Member::with('klaims')->where('user_id',auth()->user()->id)->first();
        $klaim = KlaimAsuransi::with('status_set','polis')->where('member_id',$member->id)->latest()->get();
        $pembelian = PembelianProduk::with('polis','produk')->where('member_id',$member->id)->where('status',3)->get();
        return view('member.klaim',[
            'title'=>'Klaim Asuransi',
            'member'=>$member,
            'klaims'=>$klaim,
            'pembelians'=>$pembelian
        ]);
    }

    public function form_klaim()
    {
        $member = Member::where('user_id',auth()->user()->id)->first();
        $pembelian = PembelianProduk::with('polis','produk')->where('member_id',$member->id)->where('status',3)->get();
        return view('member.form-klaim',[
            'title'=>'Form Klaim',
            'pembelians'=>$pembelian,
            'member'=>$member
        ]);
    }

    public function revisi_klaim($id)
    {
        $member = Member::where('user_id',auth()->user()->id)->first();
        $pembelian = PembelianProduk::with('polis','produk')->where('member_id',$member->id)->where('status',3)->get();
        $klaim = KlaimAsuransi::find($id);
        return view('member.revisi-klaim',[
            'title'=>'Form Klaim',
            'pembelians'=>$pembelian,
            'member'=>$member,
            'data'=>$klaim
        ]);
    }

    public function store_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required',
            'nohp' => 'required',
            'alamat' => 'required',
            'bank' => 'required',
            'rek' => 'required',
            'provinsi' => 'required',
            'kab_kota' => 'required',
        ],
        [
            '*.required' => 'Tidak boleh kosong!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                Member::create([
                    'user_id' => auth()->user()->id,
                    'nama_lengkap' => $request->nama,
                    'no_ktp' => $request->nik,
                    'no_hp' => $request->nohp,
                    'alamat' => $request->alamat,
                    'bank_id' => $request->bank,
                    'no_rekening' => $request->rek,
                    'kab_kota_id' => $request->kab_kota
                ]);
                Helper::createUserLog("Berhasil mengisi data member ".$request->nama, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal mengisi data member ".$request->nama, auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function get_polis($id)
    {
        $unduh = PolisAsuransi::select('pembelian_id','path')->where('pembelian_id',$id)->first();
        if ($unduh) {
            Helper::createUserLog("Berhasil download polis", auth()->user()->id, $this->title);
            if (Storage::exists($unduh->path)) {
                return Storage::download($unduh->path);
            }
        } else {
            Helper::createUserLog("Gagal download polis", auth()->user()->id, $this->title);
            return response()->json([
                'status'=>422,
                'message'=>'Polis tidak tersedia/rusak'
            ],422);
        }

    }

    public function get_nota_klaim($id)
    {
        $unduh = KlaimAsuransi::with('member')->select('path','member_id')->where('id',$id)->first();
        if ($unduh) {
            Helper::createUserLog("Berhasil download polis", auth()->user()->id, $this->title);
            if (Storage::exists($unduh->path)) {
                return Storage::download($unduh->path);
            }
        } else {
            Helper::createUserLog("Gagal download polis", auth()->user()->id, $this->title);
            return response()->json([
                'status'=>422,
                'message'=>'Polis tidak tersedia/rusak'
            ],422);
        }
    }

    public function cart()
    {
        if(auth()->user()->member) {
            $member = Member::where('user_id',auth()->user()->id)->first();
            $pembelian = PembelianProduk::where(function($q)use($member){
                $q->where('member_id',$member->id)
                    ->where('pay_status',false);
            })->latest()->get();
        } else {
            $member = null;
        }
        return view('member.keranjang', [
            'title'=>'Cart',
            'member'=>$member,
            'pembelians'=>$pembelian
        ]);
    }

    public function nearest_petshop()
    {
        if(auth()->user()->member) {
            $member = Member::where('user_id',auth()->user()->id)->first();
            $petshop = PetshopTerdekat::where('kab_kota_id',$member->kab_kota_id)->latest()->paginate(10)->withQueryString();
        } else {
            $member = null;
        }
        return view('member.petshop-terdekat', [
            'title'=>'Nearest Petshop',
            'member'=>$member,
            'petshops'=>$petshop
        ]);
    }

    public function activity_log()
    {
        $log = UserLog::where('user_id',auth()->user()->id)->latest()->get();
        return view('member.history', [
            'title'=>'Activity Log',
            'logs'=>$log
        ]);
    }
}
