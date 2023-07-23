<?php

namespace App\Http\Controllers\Admin\WebContent;

use Exception;
use App\Helper;
use App\Models\Faq;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public $title = 'FAQ';

    public function index()
    {
        return view('admin.web-content.faq',[
            'title' => $this->title
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::latest()->get();
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
                ->editColumn('jawaban', function($row){
                    return Str::limit($row->jawaban,30);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required|unique:faq',
            'jawaban' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                Faq::create([
                    'pertanyaan' => $request->pertanyaan,
                    'jawaban' => $request->jawaban
                ]);
                Helper::createUserLog("Berhasil menambahkan FAQ", auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah FAQ", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = Faq::find($id);
        if ($data) {
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
            'pertanyaan' => 'required',
            'jawaban' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                $data = Faq::find($request->id);
                if ($data->pertanyaan==$request->pertanyaan) {
                    $data->update([
                        'pertanyaan' => $request->pertanyaan,
                        'jawaban' => $request->jawaban
                    ]);
                    Helper::createUserLog("Berhasil mengubah FAQ", auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = Faq::where('pertanyaan',$request->pertanyaan)->whereNot('id',$request->id)->first();
                    if ($cek) {
                        return response()->json([
                            'message'=>'Pertanyaan sudah digunakan!'
                        ],404);
                    } else {
                        $data->update([
                            'pertanyaan' => $request->pertanyaan,
                            'jawaban' => $request->jawaban
                        ]);
                        Helper::createUserLog("Berhasil mengubah FAQ", auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                Helper::createUserLog("Gagal mengubah FAQ", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function destroy($id)
    {
        $data = Faq::find($id);
        try {
            Helper::createUserLog("Berhasil menghapus FAQ", auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } catch (Exception $e) {
            Helper::createUserLog("Gagal menghapus FAQ", auth()->user()->id, $this->title);
            return response()->json([
                'message'=>$e->getMessage()
            ],422);
        }
    }
}
