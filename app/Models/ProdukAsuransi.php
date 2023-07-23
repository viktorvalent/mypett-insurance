<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukAsuransi extends Model
{
    protected $table = 'produk_asuransi';
    protected $fillable = ['nama_produk','tipe_produk','kelas_kamar','limit_kamar','limit_obat','satuan_limit_kamar','satuan_limit_obat','satuan_limit_dokter'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function pembelian_produk()
    {
        return $this->hasMany(PembelianProduk::class, 'produk_id');
    }

    public function produk_benefit()
    {
        return $this->hasOne(ProdukBenefit::class, 'produk_id');
    }

    public function konten()
    {
        return $this->hasOne(PaketContent::class, 'produk_id');
    }
}
