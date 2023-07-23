<?php

namespace App\Http\Controllers\Admin\MasterData;

use Exception;
use App\Helper;
use App\Models\MasterBank;
use Illuminate\Http\Request;
use App\Models\NomorRekeningBank;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class NoRekController extends Controller
{
    public $title = 'Master Nomor Rekening';

    public function index()
    {
        $data = MasterBank::all();
        return view('admin.master-data.master-no-rekening',[
            'title' => $this->title,
            'datas' => $data
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = NomorRekeningBank::with('master_bank')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<button data-id="'.$row->id.'" class="btn btn-primary my-1 edit fs-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button data-id="'.$row->id.'" class="btn btn-danger delete fs-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 align-middle"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </button>';
                    return $action;
                })
                ->editColumn('master_bank.nama', function($row){
                    return $row->master_bank->nama;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
            'nomor_rekening' => 'required|unique:nomor_rekening_bank_payment,nomor_rekening',
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
                $rek = NomorRekeningBank::create([
                    'bank_id' => $request->bank,
                    'nomor_rekening' => $request->nomor_rekening,
                ]);
                Helper::createUserLog("Berhasil menambahkan nomor rekening bank ".$rek->master_bank->nama, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data rekening'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah nomor rekening bank", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = NomorRekeningBank::find($id);
        $bank = MasterBank::all();
        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
                'banks' => $bank
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
            'bank' => 'required',
            'nomor_rekening' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $data = NomorRekeningBank::find($id);
                if ($data->nomor_rekening==$request->nomor_rekening) {
                    $data->update([
                        'bank_id'=>$request->bank,
                        'nomor_rekening'=>$request->nomor_rekening
                    ]);
                    Helper::createUserLog("Berhasil mengubah nomor rekening bank", auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = NomorRekeningBank::where('nomor_rekening',$request->nomor_rekening)->whereNot('id',$id)->first();
                    if ($cek) {
                        return response()->json([
                            'message'=>'Nomor rekening sudah digunakan!'
                        ],404);
                    } else {
                        $data->update([
                            'bank_id'=>$request->bank,
                            'nomor_rekening'=>$request->nomor_rekening
                        ]);
                        Helper::createUserLog("Berhasil mengubah nomor rekening bank ", auth()->user()->id, $this->title);
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
        $data = NomorRekeningBank::find($id);
        if ($data) {
            Helper::createUserLog("Berhasil menghapus nomor rekening bank ".$data->master_bank->nama, auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } else {
            Helper::createUserLog("Gagal menghapus data bank", auth()->user()->id, $this->title);
            return response()->json([
                'message'=>'Gagal menghapus'
            ],422);
        }
    }
}
