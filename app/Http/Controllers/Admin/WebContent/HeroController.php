<?php

namespace App\Http\Controllers\Admin\WebContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public $title = 'Hero';

    public function index()
    {
        return view('admin.web-content.hero', [
            'title'=>$this->title
        ]);
    }
}
