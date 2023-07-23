<?php

namespace App\Http\Controllers\Admin\WebContent;

use Exception;
use App\Helper;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TestimoniController extends Controller
{
    public $title = 'Testimoni';

    public function index()
    {
        return view('admin.web-content.testimoni',[
            'title' => $this->title
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimoni::latest()->get();
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
                ->editColumn('testi_text', function($row){
                    return substr($row->testi_text,0,45).'...';
                })
                ->editColumn('foto', function ($row){
                    $path = asset(Storage::url($row->foto));
                    $null = asset('img/avatar.png');
                    if ($row->foto!=null){
                        return '<img src="'.$path.'" width="80" class="rounded-circle" />';
                    } else {
                        return '<img src="'.$null.'" width="80" class="rounded-circle" />';
                    }
                })
                ->rawColumns(['action','foto'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:testimoni',
            'pekerjaan' => 'required',
            'testi_text' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg|max:2048'
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
                $foto = $request->file('foto')->store('public/web-content/foto-testi');
                Testimoni::create([
                    'nama' => $request->nama,
                    'pekerjaan' => $request->pekerjaan,
                    'testi_text' => $request->testi_text,
                    'foto' => $foto
                ]);
                Helper::createUserLog("Berhasil menambahkan Testimoni", auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah Testimoni", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function edit($id)
    {
        $data = Testimoni::find($id);
        if ($data) {
            if (Storage::exists($data->foto)) {
                $data->foto = asset(Storage::url($data->foto));
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
            'pekerjaan' => 'required',
            'testi_text' => 'required',
            'foto' => 'nullable'
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
                $data = Testimoni::find($request->id);
                if ($data->nama==$request->nama) {
                    if($request->hasFile('foto')){
                        if(Storage::exists($data->foto)){
                            Storage::delete($data->foto);
                            $foto = $request->file('foto')->store('public/web-content/foto-testi');
                            $data->foto = $foto;
                            $data->save();
                        }
                    }
                    $data->update([
                        'nama' => $request->nama,
                        'pekerjaan' => $request->pekerjaan,
                        'testi_text' => $request->testi_text
                    ]);
                    Helper::createUserLog("Berhasil mengubah Testimoni", auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil mengubah data'
                    ]);
                } else {
                    $cek = Testimoni::where('nama',$request->nama)->whereNot('id',$request->id)->first();
                    if ($cek) {
                        return response()->json([
                            'message'=>'Pertanyaan sudah digunakan!'
                        ],404);
                    } else {
                        if($request->hasFile('foto')){
                            if(Storage::exists($data->foto)){
                                Storage::delete($data->foto);
                                $foto = $request->file('foto')->store('public/web-content/foto-testi');
                                $data->foto = $foto;
                                $data->save();
                            }
                        }
                        $data->update([
                            'nama' => $request->nama,
                            'pekerjaan' => $request->pekerjaan,
                            'testi_text' => $request->testi_text,
                        ]);
                        Helper::createUserLog("Berhasil mengubah Testimoni", auth()->user()->id, $this->title);
                        DB::commit();
                        return response()->json([
                            'status'=>200,
                            'message'=>'Berhasil mengubah data'
                        ]);
                    }
                }
            } catch (Exception $e) {
                Helper::createUserLog("Gagal mengubah Testimoni", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function destroy($id)
    {
        $data = Testimoni::find($id);
        try {
            Helper::createUserLog("Berhasil menghapus Testimoni", auth()->user()->id, $this->title);
            $data->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil menghapus data'
            ]);
        } catch (Exception $e) {
            Helper::createUserLog("Gagal menghapus Testimoni", auth()->user()->id, $this->title);
            return response()->json([
                'message'=>$e->getMessage()
            ],422);
        }
    }
}
