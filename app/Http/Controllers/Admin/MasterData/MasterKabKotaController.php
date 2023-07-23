<?php

namespace App\Http\Controllers\Admin\MasterData;

use Exception;
use App\Helper;
use Illuminate\Http\Request;
use App\Models\MasterKabKota;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MasterProvinsi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MasterKabKotaController extends Controller
{
    public $title = 'Master Kabupaten/Kota';

    public function index()
    {
        $provinsi = MasterProvinsi::all();
        return view('admin.master-data.master-kab-kota',[
            'title' => $this->title,
            'provinsi'=>$provinsi
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterKabKota::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if (!$row->petshop_terdekat()->exists() || !$row->members()->exists()) {
                        $action = '<button data-id="'.$row->id.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </button>
                                    <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>';
                    } else {
                        $action = '<button data-id="'.$row->id.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </button>
                                    <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4" disabled="disabled">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>';
                    }
                    return $action;
                })
                ->editColumn('provinsi_id.nama', function($row){
                    return $row->provinsi->nama;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:master_kab_kota',
            'provinsi_id' => 'required',
            'deskripsi' => 'nullable',
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
                MasterKabKota::create([
                    'nama' => $request->nama,
                    'provinsi_id' => $request->provinsi_id,
                    'deskripsi' => $request->deskripsi
                ]);
                Helper::createUserLog("Berhasil menambahkan kab/kota ".$request->nama, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah kab/kota", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = MasterKabKota::find($id);
        $provinsi = MasterProvinsi::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
                'provinsi' => $provinsi
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
            'nama' => 'required',
            'provinsi_id' => 'required',
            'deskripsi' => 'nullable',
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
                $data = MasterKabKota::find($id);
                if ($data->nama==$request->nama) {
                    $data->update([
                        'nama' => $request->nama,
                        'provinsi_id' => $request->provinsi_id,
                        'deskripsi' => $request->deskripsi
                    ]);
                    Helper::createUserLog("Berhasil mengubah kab/kota", auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = MasterKabKota::where(function($q)use($request){
                            $q->where('nama','=',$request->nama)
                                ->where('provinsi_id','=',$request->provinsi_id);
                        })->whereNot('id',$id)->first();
                    if ($cek) {
                        return response()->json([
                            'message'=>'Data sudah digunakan!'
                        ],404);
                    } else {
                        $data->update([
                            'nama' => $request->nama,
                            'provinsi_id' => $request->provinsi_id,
                            'deskripsi' => $request->deskripsi
                        ]);
                        Helper::createUserLog("Berhasil mengubah kab/kota ", auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                Helper::createUserLog("Gagal mengubah data kab/kota", auth()->user()->id, $this->title);
                return response()->json([
                    'status'=>422,
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function destroy($id)
    {
        $data = MasterKabKota::find($id);
        if ($data) {
            Helper::createUserLog("Berhasil menghapus kab/kota ".$data->nama, auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } else {
            Helper::createUserLog("Gagal menghapus data kab/kota", auth()->user()->id, $this->title);
            return response()->json([
                'status'=>422,
                'message'=>'Gagal menghapus'
            ],422);
        }
    }
}
