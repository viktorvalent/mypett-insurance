<?php

namespace App\Http\Controllers\Admin\MasterData;

use Exception;
use App\Helper;
use App\Models\MasterBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MasterBankController extends Controller
{
    public $title = 'Master Bank';

    public function index()
    {
        return view('admin.master-data.master-bank',[
            'title' => $this->title
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterBank::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if (!$row->nomor_rekening_bank()->exists()) {
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
                ->editColumn('logo', function ($row){
                    $path = asset(Storage::url($row->logo));
                    return '<img src="'.$path.'" width="100" />';
                })
                ->rawColumns(['action','logo'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'logo' => 'required|mimes:png,jpg,jpeg|max:2048'
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
                $logo = $request->file('logo')->store('public/master-data/bank-logo');
                MasterBank::create([
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'logo' => $logo
                ]);
                Helper::createUserLog("Berhasil menambahkan data bank ".$request->nama, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah data bank", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = MasterBank::find($id);
        if ($data) {
            if (Storage::exists($data->logo)) {
                $data->logo = asset(Storage::url($data->logo));
            }
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message'=>'Data tidak ditemukan!'
            ],422);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'logo' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $data = MasterBank::find($request->id);
                $nama_bank = $data->nama;
                $logo_path = $data->logo;

                if ($nama_bank==$request->nama) {
                    if($request->hasFile('logo')){
                        if(Storage::exists($data->logo)){
                            Storage::delete($data->logo);
                            $logo_path = $request->file('logo')->store('public/master-data/bank-logo');
                        }
                    }

                    $data->update([
                        'nama'=>$request->nama,
                        'deskripsi'=>$request->deskripsi,
                        'logo'=>$logo_path
                    ]);

                    Helper::createUserLog("Berhasil mengubah data bank ".$nama_bank, auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = MasterBank::where('nama',$request->nama)->whereNot('id',$request->id)->first();

                    if ($cek) {
                        return response()->json([
                            'message'=>'Nama sudah digunakan!'
                        ],404);
                    } else {
                        if($request->hasFile('logo')){
                            if(Storage::exists($data->logo)){
                                Storage::delete($data->logo);
                                $logo_path = $request->file('logo')->store('public/master-data/bank-logo');
                            }
                        }

                        $data->update([
                            'nama'=>$request->nama,
                            'deskripsi'=>$request->deskripsi,
                            'logo'=>$logo_path
                        ]);

                        Helper::createUserLog("Berhasil mengubah data bank ".$nama_bank, auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                Helper::createUserLog("Gagal mengubah data bank", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function destroy($id)
    {
        $data = MasterBank::find($id);
        try {
            if (Storage::exists($data->logo)) {
                Storage::delete($data->logo);
            }
            Helper::createUserLog("Berhasil menghapus data bank ".$data->nama, auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } catch (Exception $e) {
            Helper::createUserLog("Gagal menghapus data bank", auth()->user()->id, $this->title);
            return response()->json([
                'message'=>$e->getMessage()
            ],422);
        }
    }
}
