<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianProduk extends Model
{
    protected $table = 'pembelian_produk';
    protected $fillable = ['tgl_daftar_asuransi','berat_badan_kg','biaya_pendaftaran','member_id','ras_hewan_id','produk_id','nama_hewan','nama_pemilik','tgl_lahir_hewan','foto','harga_dasar_premi','status','pay_status','jangka_waktu'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function produk()
    {
        return $this->belongsTo(ProdukAsuransi::class, 'produk_id');
    }

    public function status_pembelian()
    {
        return $this->belongsTo(StatusSet::class, 'status');
    }

    public function ras_hewan()
    {
        return $this->belongsTo(MasterRasHewan::class, 'ras_hewan_id');
    }

    public function polis()
    {
        return $this->hasOne(PolisAsuransi::class, 'pembelian_id');
    }
}
