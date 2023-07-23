<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\MemberController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Member\ProdukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\WebContent\FaqController;
use App\Http\Controllers\Member\KlaimAsuransiController;
use App\Http\Controllers\Admin\Transaksi\KlaimController;
use App\Http\Controllers\Admin\Transaksi\PolisController;
use App\Http\Controllers\Admin\WebContent\HeroController;
use App\Http\Controllers\Admin\MasterData\NoRekController;
use App\Http\Controllers\Member\MemberDashboardController;
use App\Http\Controllers\Admin\MasterData\PetshopController;
use App\Http\Controllers\Admin\Transaksi\PembelianController;
use App\Http\Controllers\Admin\WebContent\TestimoniController;
use App\Http\Controllers\Admin\MasterData\MasterBankController;
use App\Http\Controllers\Admin\MasterData\MasterKabKotaController;
use App\Http\Controllers\Admin\MasterData\MasterProvinsiController;
use App\Http\Controllers\Admin\MasterData\MasterRasHewanController;
use App\Http\Controllers\Admin\MasterData\ProdukAsuransiController;
use App\Http\Controllers\Admin\MasterData\MasterJenisHewanController;
use App\Http\Controllers\Admin\UserManagement\UserController;
use App\Http\Controllers\Admin\WebContent\PakacgeContentController;
use App\Http\Controllers\Admin\WebContent\TermAndConditionsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paket-asuransi', [HomeController::class, 'paket'])->name('home.package');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('home.faqs');
Route::get('/term-and-condition', [HomeController::class, 'term_and_condition'])->name('home.tnc');
Route::get('/about', [HomeController::class, 'about'])->name('home.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/calculator', [HomeController::class, 'kalkulator'])->name('home.calculator');
Route::get('/calculator/get-ras-hewan/{id}', [HomeController::class, 'get_ras_hewan']);

// Login Admin
Route::controller(AdminController::class)->prefix('/auth/admin')->group(function(){
    Route::get('/sign-in','index')->name('sign-in.admin');
    Route::post('/authenticating','authenticate')->name('authenticating.admin');
    Route::post('/reset-password','resetPassword')->name('reset.pass.admin')->middleware('is_admin');
    Route::get('/sign-out','logout')->name('sign-out.admin');
});

// Login dan register member
Route::controller(MemberController::class)->prefix('/member')->group(function(){
    Route::get('/sign-in','index')->name('sign-in.member');
    Route::post('/authenticating','authenticate')->name('authenticating.member');
    Route::post('/registration','registration')->name('register.member');
    Route::get('/sign-out','logout')->name('sign-out.member');
});

Route::get('auth/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('auth/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('auth/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('auth/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::middleware(['is_admin'])->group(function(){
    Route::controller(DashboardController::class)->prefix('/auth/dashboard')->group(function(){
        Route::get('/','index')->name('auth.dashboard');
        Route::get('/profile','profile')->name('auth.profile');
        Route::get('/list-data','data')->name('admin.logs');
    });

    Route::controller(MasterBankController::class)->prefix('/auth/dashboard/master-bank')->group(function(){
        Route::get('/','index')->name('master-data.bank');
        Route::get('/list-data','data')->name('master-bank.data');
        Route::post('/create','store')->name('master-data.bank.create');
        Route::get('/edit/{id}','edit');
        Route::post('/update','update')->name('master-data.bank.update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(NoRekController::class)->prefix('/auth/dashboard/master-nomor-rekening')->group(function(){
        Route::get('/','index')->name('master-data.no-rek');
        Route::get('/list-data','data')->name('no-rek.data');
        Route::post('/create','store')->name('master-data.no-rek.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(MasterJenisHewanController::class)->prefix('/auth/dashboard/master-jenis-hewan')->group(function(){
        Route::get('/','index')->name('master-data.jenis-hewan');
        Route::get('/list-data','data')->name('jenis-hewan.data');
        Route::post('/create','store')->name('master-data.jenis-hewan.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(MasterRasHewanController::class)->prefix('/auth/dashboard/master-ras-hewan')->group(function(){
        Route::get('/','index')->name('master-data.ras-hewan');
        Route::get('/list-data','data')->name('ras-hewan.data');
        Route::post('/create','store')->name('master-data.ras-hewan.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(MasterProvinsiController::class)->prefix('/auth/dashboard/master-provinsi')->group(function(){
        Route::get('/','index')->name('master-data.provinsi');
        Route::get('/list-data','data')->name('provinsi.data');
        Route::post('/create','store')->name('master-data.provinsi.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(MasterKabKotaController::class)->prefix('/auth/dashboard/master-kab-kota')->group(function(){
        Route::get('/','index')->name('master-data.kab-kota');
        Route::get('/list-data','data')->name('kab-kota.data');
        Route::post('/create','store')->name('master-data.kab-kota.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(PetshopController::class)->prefix('/auth/dashboard/petshop-terdekat')->group(function(){
        Route::get('/','index')->name('master-data.petshop-terdekat');
        Route::get('/list-data','data')->name('petshop-terdekat.data');
        Route::post('/create','store')->name('master-data.petshop-terdekat.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(PembelianController::class)->prefix('/auth/dashboard/pembelian-asuransi')->group(function(){
        Route::get('/','index')->name('pembelian');
        Route::get('/list-data','data')->name('pembelian.data');
        Route::post('/create','store')->name('pembelian.create');
        Route::post('/confirm','confirm_pembelian')->name('pembelian.confirm');
        Route::get('/detail/{id}','check_detail')->name('pembelian.detail');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
        Route::get('/testpdf/{id}','pdf')->name('test.pdf');
    });

    Route::controller(PolisController::class)->prefix('/auth/dashboard/polis-asuransi')->group(function(){
        Route::get('/','index')->name('polis');
        Route::get('/list-data','data')->name('polis.data');
        Route::post('/create','store')->name('polis.create');
        Route::get('/preview/{id}','polis_preview')->name('polis.preview');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
        Route::get('/testpdf/{id}','pdf')->name('test.pdf.polis');

    });

    Route::controller(KlaimController::class)->prefix('/auth/dashboard/klaim-asuransi')->group(function(){
        Route::get('/','index')->name('klaim');
        Route::get('/list-data','data')->name('klaim.data');
        Route::post('/create','store')->name('klaim.create');
        Route::get('/preview/{id}','klaim_preview')->name('klaim.preview');
        Route::get('/detail/{id}','check_detail')->name('klaim.detail');
        Route::post('/confirm','confirm_klaim')->name('klaim.confirm');
        Route::post('/reject','reject_klaim')->name('klaim.reject');
        Route::post('/nominal-confirmation','nominal_confirmation')->name('klaim.nominal-confirmation');
        Route::post('/partial-confirmation','partial')->name('klaim.partial-confirmation');
        Route::get('/edit/{id}','edit');
        Route::get('/testpdf/{id}','pdf')->name('test.pdf.klaim');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(ProdukAsuransiController::class)->prefix('/auth/dashboard/produk-asuransi')->group(function(){
        Route::get('/','index')->name('master-data.produk-asuransi');
        Route::get('/tambah','addProduk')->name('master-data.add-produk');
        Route::get('/list-data','data')->name('produk-asuransi.data');
        Route::post('/create','store')->name('master-data.produk-asuransi.create');
        Route::get('/detail/{id}','detail')->name('master-data.produk-asuransi.detail');
        Route::get('/edit/{id}','edit')->name('produk-asuransi.edit');
        Route::post('/update','update')->name('master-data.produk-asuransi.update');;
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(FaqController::class)->prefix('/auth/dashboard/faq')->group(function(){
        Route::get('/','index')->name('web-content.faq');
        Route::get('/list-data','data')->name('faq.data');
        Route::post('/create','store')->name('web-content.faq.create');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(TestimoniController::class)->prefix('/auth/dashboard/testimoni')->group(function(){
        Route::get('/','index')->name('web-content.testimoni');
        Route::get('/list-data','data')->name('testimoni.data');
        Route::post('/create','store')->name('web-content.testimoni.create');
        Route::get('/edit/{id}','edit');
        Route::post('/update','update');
        Route::get('/delete/{id}','destroy');
    });

    Route::controller(TermAndConditionsController::class)->prefix('/auth/dashboard/tnc')->group(function(){
        Route::get('/','index')->name('web-content.tnc');
        Route::get('/list-data','data')->name('tnc.data');
        Route::post('/create','update')->name('web-content.tnc.updateOrCreate');
        Route::get('/edit/{id}','edit');
    });

    Route::controller(HeroController::class)->prefix('/auth/dashboard/hero')->group(function(){
        Route::get('/','index')->name('web-content.hero');
        Route::get('/list-data','data')->name('hero.data');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
    });

    Route::controller(PakacgeContentController::class)->prefix('/auth/dashboard/package-content')->group(function(){
        Route::get('/','index')->name('web-content.package-content');
        Route::get('/list-data','data')->name('package-content.data');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
    });

    Route::controller(UserController::class)->prefix('/auth/dashboard/users')->group(function(){
        Route::get('/','index')->name('user.manage');
        Route::get('/{id}','detail')->name('member.detail');
        Route::get('/list-data','data')->name('user.data');
        Route::get('/edit/{id}','edit');
        Route::put('/update/{id}','update');
    });
});

Route::middleware(['is_member'])->group(function(){
    Route::controller(MemberDashboardController::class)->prefix('/member')->group(function(){
        Route::get('/profile', 'index')->name('member.dashboard');
        Route::get('/profile/edit/{id}', 'edit')->name('member.edit');
        Route::post('/profile/update/', 'update')->name('member.update');
        Route::get('/get-kab-kota/{id}', 'get_kab_kota');
        Route::get('/my-insurance', 'my_insurance')->name('member.my-insurance');
        Route::post('/add-member-data', 'store_member')->name('member.create');
        Route::get('/download-polis/{id}', 'get_polis')->name('member.download.polis');
        Route::get('/download-nota-klaim/{id}', 'get_nota_klaim')->name('member.download.nota_klaim');
        Route::get('/claim', 'klaim')->name('member.claim');
        Route::get('/claim/form', 'form_klaim')->name('member.claim.form');
        Route::get('/claim/revisi/{id}', 'revisi_klaim')->name('member.claim.revisi');
        Route::get('/cart', 'cart')->name('member.cart');
        Route::get('/nearest-petshop', 'nearest_petshop')->name('member.nearest-petshop');
        Route::get('/activity-log', 'activity_log')->name('member.log');
    });

    Route::controller(ProdukController::class)->prefix('/pembelian')->group(function(){
        Route::get('/','index')->name('pembelian.produk');
        Route::get('/getRas/{id}','get_ras');
        Route::post('/beli','pembelian')->name('pembelian.create');
        Route::get('/bayar','form_bayar')->name('pembelian.bayar');
        Route::get('/bayar/{id}','form_bayar_cart')->name('pembelian.bayar.cart');
        Route::post('/bayar/konfirmasi','konfirmasi_bayar')->name('pembelian.bayar.konfirmasi');
    });

    Route::controller(KlaimAsuransiController::class)->prefix('/claim')->group(function(){
        Route::post('/make-claim','klaim')->name('claim.make');
        Route::post('/make-revisi','revisi')->name('claim.revisi');
        Route::get('/cek-detail/{id}','accept_detail');
        Route::get('/confirm-detail/{id}','confirm_detail');
        Route::get('/partial-confirm/{id}','partial_confirm');
        Route::post('/agree-partial-confirm','agree_partial_confirm')->name('agree.partial');
        Route::post('/agree-limit-confirm','agree_limit_confirm')->name('agree.limit');
    });
});
