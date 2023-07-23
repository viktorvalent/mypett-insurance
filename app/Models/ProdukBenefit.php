<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukBenefit extends Model
{
    protected $table = 'produk_benefit';
    protected $fillable = ['produk_id','nilai_pertanggungan_min','nilai_pertanggungan_max','santunan_mati_kecelakaan_max','santunan_pencurian_max','hukum_pihak_ketiga_max','santunan_kremasi_max','santunan_rawat_inap_max'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
