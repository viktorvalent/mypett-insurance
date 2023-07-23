<?php

namespace App\Http\Controllers\Admin\Transaksi;

use PDF;
use Exception;
use App\Helper;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KlaimAsuransi;
use Yajra\DataTables\DataTables;
use App\Models\PolisKlaimParsial;
use App\Models\TolakKlaimAsuransi;
use Illuminate\Support\Facades\DB;
use App\Models\TerimaKlaimAsuransi;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\KonfirmasiKlaimAsuransi;
use App\Models\LimitConfirmationKlaim;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KlaimController extends Controller
{
    public $title = 'Klaim Asuransi Member';
    public function index()
    {
        return view('admin.transaksi.klaim',[
            'title'=>$this->title
        ]);
    }

    public function check_detail($id)
    {
        $data = KlaimAsuransi::with('polis','member','status_set')->find($id);
        Helper::limitClaimAccumulator($data->polis_id);
        $cek_limit = PolisKlaimParsial::select('limit_klaim')->where(function($q)use($data){
                        $q->where('polis_id',$data->polis_id)
                            ->whereDate('tgl_mulai','<=',date('Y-m-d'))
                            ->whereDate('tgl_berakhir','>',date('Y-m-d'));
                    })->first();
        $limit_klaim = $cek_limit->limit_klaim;
        $status = false;
        $total_klaim = $data->nominal_disetujui!=null?$data->nominal_disetujui:$data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter;
        ($total_klaim <= $limit_klaim)?$status=true:$status=false;

        return view('admin.transaksi.detail-klaim', [
            'title'=>'Detail Klaim Asuransi Member',
            'data'=>$data,
            'status'=>$status,
            'limit_klaim'=>$limit_klaim
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = KlaimAsuransi::with('member','polis','status_set')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $link = URL::route('klaim.detail',['id'=>$row->id]);
                    if ($row->status_set->id==1) {
                        return '<a href="'.$link.'" class="btn btn-success btn-sm"><i class="bi bi-search"></i> Check</a>';
                    } elseif ($row->status_set->id==2) {
                        return '<a href="'.$link.'" class="btn btn-success btn-sm"><i class="bi bi-search"></i> Check</a>';
                    } elseif ($row->status_set->id==3) {
                        return '<a href="'.$link.'" class="btn btn-success btn-sm"><i class="bi bi-search"></i> Check</a>';
                    } else {
                        return '<a href="'.$link.'" class="btn btn-success btn-sm"><i class="bi bi-search"></i> Check</a>';
                    }
                })->editColumn('tgl_klaim', function($row){
                    return Carbon::createFromFormat('Y-m-d', $row->tgl_klaim, 'Asia/Jakarta')->format('d-m-Y');
                })
                ->editColumn('polis_id.polis.nomor_polis', function($row){
                    return $row->polis->nomor_polis;
                })
                ->editColumn('member_id.member.nama_lengkap', function($row){
                    return $row->member->nama_lengkap;
                })
                ->addColumn('total_klaim', function($row){
                    return 'Rp '.number_format(($row->nominal_bayar_rs+$row->nominal_bayar_dokter+$row->nominal_bayar_obat),0,'','.');
                })
                ->editColumn('status_klaim.status_set.status', function($row){
                    if ($row->status_set->id==1) {
                        return '<span class="badge text-bg-light shadow-sm">'.$row->status_set->status.'</span>';
                    } elseif ($row->status_set->id==2) {
                        return '<span class="badge text-bg-danger text-white shadow-sm">'.$row->status_set->status.'</span>';
                    } elseif ($row->status_set->id==3) {
                        return '<span class="badge text-bg-success text-white shadow-sm">'.$row->status_set->status.'</span>';
                    } elseif ($row->status_set->id==7) {
                        return '<span class="badge text-bg-info shadow-sm">'.$row->status_set->status.'</span>';
                    } else {
                        return '<span class="badge text-bg-warning shadow-sm">'.$row->status_set->status.'</span>';
                    }
                })
                ->rawColumns(['action','status_klaim.status_set.status','total_klaim'])
                ->make(true);
        }
    }

    public function confirm_klaim(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bukti_bayar_klaim' => 'required|mimes:png,jpg,jpeg|max:2048',
        ],
        [
            '*.required' => 'Tidak boleh kosong!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ],400);
        } else {
            if (!empty($request->id)) {
                try {
                    DB::beginTransaction();
                    $data = KlaimAsuransi::with('polis','member','status_set','konfirmasi_klaim_asuransi','limit_confirmation_klaim')->find($request->id);
                    $parsial = PolisKlaimParsial::where(function($q)use($data){$q->where('polis_id',$data->polis_id)->whereDate('tgl_mulai','<=',date('Y-m-d'))->whereDate('tgl_berakhir','>',date('Y-m-d'));})->first();
                    if ($request->hasFile('bukti_bayar_klaim')) {
                        $bukti = $request->file('bukti_bayar_klaim')->store('public/konfirmasi-klaim/member_'.Str::slug($data->member->nama_lengkap));
                        TerimaKlaimAsuransi::create([
                            'klaim_id'=>$request->id,
                            'bukti_bayar_klaim'=>$bukti,
                            'keterangan_alasan'=>$request->keterangan
                        ]);
                    }
                    view()->share('data',['data'=>$data]);
                    $pdf = PDF::loadView('template.klaim-asuransi', ['data'=>$data]);
                    $date = Str::remove('-', strval(Carbon::now()->format('Y-m-d')));
                    $pdf_file = $pdf->download()->getOriginalContent();
                    $member = Str::slug($data->member->nama_lengkap,'-');
                    $path = strval('public/klaim-asuransi/'.$member.'/MYPETT_CLAIM_'.$date.'_'.strval(md5($data->id)).'.pdf');
                    Storage::put($path, $pdf_file);
                    if (Storage::exists($path)) {
                        KlaimAsuransi::where('id',$request->id)->update([
                            'status_klaim'=>3,
                            'path'=>$path
                        ]);
                        $parsial->limit_klaim = $parsial->limit_klaim - $request->total_klaim;
                        $parsial->save();
                    }
                    Helper::createUserLog("Berhasil konfirmasi klaim untuk member ".$data->member->nama_lengkap, auth()->user()->id, $this->title);
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                        'message'=>'Berhasil membuat nota klaim'
                    ]);
                } catch (Exception $e) {
                    DB::rollBack();
                    Helper::createUserLog("Gagal konfirmasi klaim", auth()->user()->id, $this->title);
                    return response()->json([
                        'message'=>$e->getMessage()
                    ],422);
                }
            } else {
                return response()->json([
                    'status'=>404,
                    'message'=>'Data pembelian expired!'
                ],404);
            }
        }
    }

    public function partial(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = KlaimAsuransi::with('polis','member','status_set')->find($request->id);
            $data->update(['status_klaim'=>6]);
            KonfirmasiKlaimAsuransi::create([
                'klaim_id'=>$data->id,
                'nominal_ditawarkan'=>$request->nominal_ditawarkan,
                'alasan'=>$request->keterangan,
                'nominal_bayar_rs'=>$request->rs,
                'nominal_bayar_obat'=>$request->obat,
                'nominal_bayar_dokter'=>$request->dokter
            ]);
            Helper::createUserLog("Berhasil melakukan klaim pembagian klaim", auth()->user()->id, $this->title);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'Berhasil konfirmasi partial'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Helper::createUserLog("Gagal melakukan partial", auth()->user()->id, $this->title);
            return response()->json([
                'message'=>$e->getMessage()
            ],422);
        }
    }

    public function reject_klaim(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'alasan' => 'required',
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
                $data = KlaimAsuransi::find($request->id);
                TolakKlaimAsuransi::create([
                    'klaim_id'=>$data->id,
                    'alasan_menolak'=>$request->alasan
                ]);
                $data->update(['status_klaim'=>2]);
                Helper::createUserLog("Berhasil konfirmasi klaim untuk member ".$data->member->nama_lengkap, auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menolak klaim'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal menolak klaim", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }

    public function nominal_confirmation(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'alasan' => 'required',
            'nominal_ditawarkan' => 'required',
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
                $data = KlaimAsuransi::find($request->id);
                LimitConfirmationKlaim::create([
                    'klaim_id'=>$data->id,
                    'nominal_ditawarkan'=>$request->nominal_ditawarkan,
                    'nominal_limit'=>$request->nominal_limit,
                    'nominal_pengajuan'=>$request->nominal_pengajuan,
                    'alasan'=>$request->alasan
                ]);
                $data->update(['status_klaim'=>5]);
                Helper::createUserLog("Berhasil konfirmasi nominal", auth()->user()->id, $this->title);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'Berhasil menolak klaim'
                ]);
            } catch (Exception $e) {
                DB::rollBack();
                Helper::createUserLog("Gagal konfirmasi nominal", auth()->user()->id, $this->title);
                return response()->json([
                    'message'=>$e->getMessage()
                ],422);
            }
        }
    }
}
