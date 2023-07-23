<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Models\User;
use App\Models\Member;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Models\KlaimAsuransi;
use App\Models\PolisAsuransi;
use App\Models\PembelianProduk;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public $title = 'Dashboard';

    public function index()
    {
        $data['member'] = Member::count();
        $data['asuransi'] = PembelianProduk::count();
        $data['polis'] = PolisAsuransi::count();
        $data['klaim'] = KlaimAsuransi::count();
        $data['chart'] = json_encode(Helper::chartData());
        $data['m_persen'] = Helper::getPersenByWeek(Member::class);
        $data['a_persen'] = Helper::getPersenByWeek(PembelianProduk::class);
        $data['p_persen'] = Helper::getPersenByWeek(PolisAsuransi::class);
        $data['k_persen'] = Helper::getPersenByWeek(KlaimAsuransi::class);
        $data['acc_klaim'] = KlaimAsuransi::where('status_klaim',3)->count();
        $data['rej_klaim'] = KlaimAsuransi::where('status_klaim',2)->count();
        $data['await_klaim'] = KlaimAsuransi::where('status_klaim',1)->count();
        $pie = [$data['acc_klaim'],$data['rej_klaim'],$data['await_klaim']];
        $data['chart_pie'] = json_encode($pie);
        return view('admin.app',[
            'title'=>$this->title,
            'data'=>$data
        ]);
    }

    public function profile()
    {
        $data = User::select('username','email','password','role')->find(auth()->user()->id);
        return view('admin.profile', [
            'data'=>$data,
            'title'=>'Profile'
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = UserLog::where('user_id',auth()->user()->id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', function($row){
                    return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d/m/Y');
                })
                ->rawColumns(['tanggal'])
                ->make(true);
        }
    }
}
