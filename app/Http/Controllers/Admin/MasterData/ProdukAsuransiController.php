<?php

namespace App\Http\Controllers\Admin\MasterData;

use Exception;
use App\Helper;
use Illuminate\Http\Request;
use App\Models\ProdukAsuransi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PaketContent;
use App\Models\ProdukBenefit;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProdukAsuransiController extends Controller
{
    public $title = 'Produk Asuransi';

    public function index()
    {
        return view('admin.master-data.produk-asuransi', [
            'title' => $this->title,
        ]);
    }

    public function addProduk()
    {
        return view('admin.master-data.add-produk-asuransi',[
            'title' => 'Tambah Produk Asuransi'
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = ProdukAsuransi::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $edit = URL::route('produk-asuransi.edit', ['id'=>$row->id]);
                    if (!$row->pembelian_produk()->exists() && !$row->produk_benefit()->exists() && !$row->konten()->exists()) {
                        $action = '<a href="'.$edit.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>';
                    } else {
                        $action = '<a href="'.$edit.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4" disabled="disabled">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>';
                    }
                    return $action;
                })
                ->editColumn('konten.icon', function($row){
                    return $row->konten->icon;
                })
                ->editColumn('limit_kamar', function($row){
                    return 'Rp '.number_format($row->limit_kamar,0,'','.');
                })
                ->editColumn('limit_obat', function($row){
                    return 'Rp '.number_format($row->limit_kamar,0,'','.');
                })
                ->rawColumns(['action','konten.icon'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'kelas_kamar' => 'required',
            'limit_kamar' => 'required',
            'limit_obat' => 'required',
            'satuan_limit_kamar' => 'required',
            'satuan_limit_obat' => 'required',
            'satuan_limit_dokter' => 'required',
            'nilai_pertanggungan_min' => 'required',
            'nilai_pertanggungan_max' => 'required',
            'santunan_mati_kecelakaan' => 'required',
            'santunan_kecurian' => 'required',
            'tanggung_jawab_hukum' => 'required',
            'santunan_kremasi' => 'required',
            'santunan_rawat_inap' => 'required',
            'harga_konten' => 'required',
            'icon' => 'required',
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
                $produk = ProdukAsuransi::create([
                    'nama_produk' => $request->nama_produk,
                    'kelas_kamar' => $request->kelas_kamar,
                    'limit_kamar' => $request->limit_kamar,
                    'limit_obat' => $request->limit_obat,
                    'satuan_limit_kamar' => $request->satuan_limit_kamar,
                    'satuan_limit_obat' => $request->satuan_limit_obat,
                    'satuan_limit_dokter' => $request->satuan_limit_dokter,
                ]);
                if($produk) {
                    ProdukBenefit::create([
                        'produk_id' => $produk->id,
                        'nilai_pertanggungan_min' => $request->nilai_pertanggungan_min,
                        'nilai_pertanggungan_max' => $request->nilai_pertanggungan_max,
                        'santunan_mati_kecelakaan_max' => $request->santunan_mati_kecelakaan,
                        'santunan_pencurian_max' => $request->santunan_kecurian,
                        'hukum_pihak_ketiga_max' => $request->tanggung_jawab_hukum,
                        'santunan_kremasi_max' => $request->santunan_kremasi,
                        'santunan_rawat_inap_max' => $request->santunan_rawat_inap
                    ]);
                    PaketContent::create([
                        'produk_id'=>$produk->id,
                        'nama'=>$produk->nama_produk,
                        'icon'=>$request->icon,
                        'warna'=>'#0081c9',
                        'harga'=>$request->harga_konten
                    ]);
                }
                Helper::createUserLog("Berhasil menambahkan produk asuransi ".$produk->nama_produk, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan produk'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah produk asuransi", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = ProdukAsuransi::with('produk_benefit','konten')->find($id);
        if($data) {
            return view('admin.master-data.edit-produk-asuransi', [
                'title' => $this->title,
                'data'=>$data
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'kelas_kamar' => 'required',
            'limit_kamar' => 'required',
            'limit_obat' => 'required',
            'satuan_limit_kamar' => 'required',
            'satuan_limit_obat' => 'required',
            'satuan_limit_dokter' => 'required',
            'nilai_pertanggungan_min' => 'required',
            'nilai_pertanggungan_max' => 'required',
            'santunan_mati_kecelakaan' => 'required',
            'santunan_kecurian' => 'required',
            'tanggung_jawab_hukum' => 'required',
            'santunan_kremasi' => 'required',
            'santunan_rawat_inap' => 'required',
            'harga_konten' => 'required',
            'icon' => 'required',
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
                $produk = ProdukAsuransi::find($request->id);
                if ($produk->nama_produk==$request->nama_produk) {
                    $produk->update([
                        'nama_produk' => $request->nama_produk,
                        'kelas_kamar' => $request->kelas_kamar,
                        'limit_kamar' => $request->limit_kamar,
                        'limit_obat' => $request->limit_obat,
                        'satuan_limit_kamar' => $request->satuan_limit_kamar,
                        'satuan_limit_obat' => $request->satuan_limit_obat,
                        'satuan_limit_dokter' => $request->satuan_limit_dokter,
                    ]);
                    if($produk) {
                        $benefit = ProdukBenefit::where('produk_id',$request->id)->first();
                        $benefit->update([
                            'produk_id' => $produk->id,
                            'nilai_pertanggungan_min' => $request->nilai_pertanggungan_min,
                            'nilai_pertanggungan_max' => $request->nilai_pertanggungan_max,
                            'santunan_mati_kecelakaan_max' => $request->santunan_mati_kecelakaan,
                            'santunan_pencurian_max' => $request->santunan_kecurian,
                            'hukum_pihak_ketiga_max' => $request->tanggung_jawab_hukum,
                            'santunan_kremasi_max' => $request->santunan_kremasi,
                            'santunan_rawat_inap_max' => $request->santunan_rawat_inap
                        ]);
                        $content = PaketContent::where('produk_id',$request->id)->first();
                        $content->update([
                            'produk_id'=>$produk->id,
                            'nama'=>$produk->nama_produk,
                            'icon'=>$request->icon,
                            'warna'=>'#0081c9',
                            'harga'=>$request->harga_konten
                        ]);
                    }
                    Helper::createUserLog("Berhasil mengubah produk asuransi ".$produk->nama_produk, auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah produk'
                    ]);
                } else {
                    $cek = ProdukAsuransi::where('nama_produk',$request->nama_produk)->whereNot('id',$request->id)->first();
                    if ($cek) {
                        return response()->json([
                            'status'=>404,
                            'message'=>'Nama produk sudah digunakan!'
                        ],404);
                    } else {
                        $produk->update([
                            'nama_produk' => $request->nama_produk,
                            'kelas_kamar' => $request->kelas_kamar,
                            'limit_kamar' => $request->limit_kamar,
                            'limit_obat' => $request->limit_obat,
                            'satuan_limit_kamar' => $request->satuan_limit_kamar,
                            'satuan_limit_obat' => $request->satuan_limit_obat,
                            'satuan_limit_dokter' => $request->satuan_limit_dokter,
                        ]);
                        if($produk) {
                            $benefit = ProdukBenefit::where('produk_id',$request->id)->first();
                            $benefit->update([
                                'produk_id' => $produk->id,
                                'nilai_pertanggungan_min' => $request->nilai_pertanggungan_min,
                                'nilai_pertanggungan_max' => $request->nilai_pertanggungan_max,
                                'santunan_mati_kecelakaan_max' => $request->santunan_mati_kecelakaan,
                                'santunan_pencurian_max' => $request->santunan_kecurian,
                                'hukum_pihak_ketiga_max' => $request->tanggung_jawab_hukum,
                                'santunan_kremasi_max' => $request->santunan_kremasi,
                                'santunan_rawat_inap_max' => $request->santunan_rawat_inap
                            ]);
                        }
                        Helper::createUserLog("Berhasil mengubah produk asuransi ".$produk->nama_produk, auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah produk'
                        ]);
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal mengubah produk asuransi", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }
}
