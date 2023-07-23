<?php

namespace App\Http\Controllers\Admin\MasterData;

use Exception;
use App\Helper;
use Illuminate\Http\Request;
use App\Models\MasterKabKota;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PetshopTerdekat;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PetshopController extends Controller
{
    public $title = 'Petshop Terdekat';

    public function index()
    {
        $kabkotas = MasterKabKota::all();
        return view('admin.master-data.petshop-terdekat',[
            'title' => $this->title,
            'kabkotas'=>$kabkotas
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = PetshopTerdekat::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<button data-id="'.$row->id.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>';
                    return $action;
                })
                ->editColumn('kab_kota_id.nama', function($row){
                    return $row->kab_kota->nama;
                })
                ->rawColumns(['action','gmaps_iframe'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petshop' => 'required|unique:petshop_terdekat',
            'kab_kota_id' => 'required',
            'keterangan_petshop' => 'nullable',
            'gmaps_iframe' => 'required',
            'alamat' => 'required'
        ],
        [
            '*.required' => 'Tidak boleh kosong!',
            '*.unique' => 'Data sudah digunakan!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                PetshopTerdekat::create([
                    'nama_petshop' => $request->nama_petshop,
                    'kab_kota_id' => $request->kab_kota_id,
                    'alamat' => $request->alamat,
                    'keterangan_petshop' => $request->keterangan_petshop,
                    'gmaps_iframe' => $request->gmaps_iframe,
                ]);
                Helper::createUserLog("Berhasil menambahkan petshop terdekat ".$request->nama_petshop, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah petshop terdekat", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = PetshopTerdekat::find($id);
        $kabkota = MasterKabKota::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
                'kabkota' => $kabkota
            ]);
        } else {
            return response()->json([
                'message'=>'Data tidak ditemukan!'
            ],422);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_petshop' => 'required',
            'kab_kota_id' => 'required',
            'keterangan_petshop' => 'nullable',
            'gmaps_iframe' => 'required',
            'alamat' => 'required',
        ],
        [
            '*.required' => 'Tidak boleh kosong!',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $data = PetshopTerdekat::find($id);
                if ($data->nama==$request->nama) {
                    $data->update([
                        'nama_petshop' => $request->nama_petshop,
                        'kab_kota_id' => $request->kab_kota_id,
                        'alamat' => $request->alamat,
                        'keterangan_petshop' => $request->keterangan_petshop,
                        'gmaps_iframe' => $request->gmaps_iframe,
                    ]);
                    Helper::createUserLog("Berhasil mengubah petshop terdekat", auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = PetshopTerdekat::where(function($q)use($request){
                            $q->where('nama_petshop','=',$request->nama_petshop)
                                ->where('kab_kota_id','=',$request->kab_kota_id);
                        })->whereNot('id',$id)->first();
                    if ($cek) {
                        return response()->json([
                            'message'=>'Data sudah digunakan!'
                        ],404);
                    } else {
                        $data->update([
                            'nama_petshop' => $request->nama_petshop,
                            'kab_kota_id' => $request->kab_kota_id,
                            'keterangan_petshop' => $request->keterangan_petshop,
                            'alamat' => $request->alamat,
                            'gmaps_iframe' => $request->gmaps_iframe,
                        ]);
                        Helper::createUserLog("Berhasil mengubah petshop terdekat ", auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                Helper::createUserLog("Gagal mengubah data petshop terdekat", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function destroy($id)
    {
        $data = PetshopTerdekat::find($id);
        if ($data) {
            Helper::createUserLog("Berhasil menghapus petshop terdekat ".$data->nama, auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } else {
            Helper::createUserLog("Gagal menghapus data petshop terdekat", auth()->user()->id, $this->title);
            return response()->json([
                'status'=>422,
                'message'=>'Gagal menghapus'
            ],422);
        }
    }
}
