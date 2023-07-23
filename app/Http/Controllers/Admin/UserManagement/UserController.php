<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public $title = 'Users';

    public function index()
    {
        $data = Member::all();
        return view('admin.manajemen-akun.user',[
            'title' => $this->title,
            'datas'=>$data
        ]);
    }

    public function detail($id)
    {
        $data = Member::with('master_bank')->find($id);
        if ($data) {
            return view('admin.manajemen-akun.member-detail',[
                'data'=>$data,
                'title'=>$this->title
            ]);
        }
    }
}
