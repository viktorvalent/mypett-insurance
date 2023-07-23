<?php

namespace App\Http\Controllers\Admin\Transaksi;

use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use App\Models\PolisAsuransi;
use App\Models\PembelianProduk;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class PolisController extends Controller
{
    public $title = 'Polis Asuransi Member';

    public function index()
    {
        return view('admin.transaksi.polis', [
            'title'=>$this->title
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = PolisAsuransi::with('pembelian.member')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('pembelian_id.member.nama_lengkap', function($row){
                    return $row->pembelian->member->nama_lengkap;
                })
                ->editColumn('jangka_waktu', function($row){
                    return $row->jangka_waktu.' Tahun';
                })
                ->editColumn('nomor_polis', function($row){
                    $link = URL::route('polis.preview',['id'=>$row->id]);
                    return '<a href="'.$link.'" class="fw-bold">'.$row->nomor_polis.'</a>';
                })
                ->editColumn('tgl_polis_mulai', function($row){
                    return Carbon::createFromFormat('Y-m-d',$row->tgl_polis_mulai)->format('d-m-Y');
                })
                ->rawColumns(['pembelian_id.member.nama_lengkap','nomor_polis'])
                ->make(true);
        }
    }

    public function polis_preview($id)
    {
        $data = PolisAsuransi::select('path','nomor_polis')->find($id);
        if ($data) {
            return view('admin.transaksi.polis-preview',[
                'data'=>$data,
                'title'=>'Polis Preview'
            ]);
        }
    }

    // for testing template pdf klaim
    public function pdf($id)
    {
        $data = PembelianProduk::with('produk','ras_hewan.jenis_hewan','member','polis')->find($id);
        view()->share('data',['data'=>$data]);
        $pdf = PDF::loadView('template.polis-asuransi', ['data'=>$data]);
        return $pdf->download('polis.pdf');
    }
}
