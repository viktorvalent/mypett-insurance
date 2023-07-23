<?php

namespace App\Http\Controllers\Landing;

use App\Models\Faq;
use App\Models\Testimoni;
use App\Models\PaketContent;
use Illuminate\Http\Request;
use App\Models\ProdukAsuransi;
use App\Models\TermAndConditions;
use App\Http\Controllers\Controller;
use App\Models\MasterJenisHewan;
use App\Models\MasterRasHewan;

class HomeController extends Controller
{
    public function index()
    {
        $faq = Faq::latest()->limit(5)->get();
        $package = PaketContent::latest()->get();
        $testimonials = Testimoni::select('nama','pekerjaan','foto','testi_text')->get();
        return view('landing.home', [
            'title'=>'Home',
            'faqs'=>$faq,
            'packages'=>$package,
            'testimonials'=>$testimonials
        ]);
    }

    public function paket()
    {
        $paket = ProdukAsuransi::latest()->get();
        return view('landing.paket', [
            'title'=>'Paket Asuransi',
            'pakets'=>$paket
        ]);
    }

    public function faqs()
    {
        $faq = Faq::latest()->paginate(10)->withQueryString();
        return view('landing.faqs', [
            'title'=>'FAQs',
            'faqs'=>$faq
        ]);
    }

    public function term_and_condition()
    {
        $data = TermAndConditions::select('isi')->first();
        return view('landing.term-and-condition', [
            'title'=>'Term & Condition',
            'data'=>$data
        ]);
    }

    public function kalkulator()
    {
        $jenis = MasterJenisHewan::select('id','nama')->get();
        return view('landing.premi-kalkulator', [
            'title'=>'Kalkulator',
            'jeniss'=>$jenis
        ]);
    }

    public function get_ras_hewan($id)
    {
        $data = MasterRasHewan::where('jenis_hewan_id',$id)->get();

        if ($data) {
            return response()->json([
                'status'=>200,
                'data'=>$data
            ]);
        }
    }

    public function about()
    {
        return view('landing.about',[
            'title'=>'About'
        ]);
    }

    public function contact()
    {
        return view('landing.contact',[
            'title'=>'Contact'
        ]);
    }
}
