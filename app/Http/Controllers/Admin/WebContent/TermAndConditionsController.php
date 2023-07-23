<?php

namespace App\Http\Controllers\Admin\WebContent;

use Exception;
use App\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TermAndConditions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TermAndConditionsController extends Controller
{
    public $title = 'Term & Conditions';

    public function index()
    {
        return view('admin.web-content.term-and-conditions', [
            'title'=>$this->title
        ]);
    }

    public function edit($id)
    {
        $data = TermAndConditions::find($id);
        return view('admin.web-content.add-term-and-conditions', [
            'title'=>$this->title,
            'data'=>$data
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = TermAndConditions::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $action = '<button data-id="'.$row->id.'" class="btn btn-primary my-1 edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit align-middle"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>';
                    return $action;
                })
                ->editColumn('isi', function($row){
                    return Str::limit(strip_tags($row->isi),100);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isi' => 'required',
        ],[
            'isi.required'=>'Term & condition tidak boleh kosong!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            try {
                DB::beginTransaction();
                TermAndConditions::where('id','=',$request->id)->update([
                    'isi' => $request->isi,
                ]);
                Helper::createUserLog("Berhasil menambahkan Term & Conditions", auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menambahkan data'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menambah Term & Conditions", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }
}
