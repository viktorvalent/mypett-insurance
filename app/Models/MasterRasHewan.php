<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterRasHewan extends Model
{
    protected $table = 'master_ras_hewan';
    protected $fillable = ['nama_ras','deskripsi','jenis_hewan_id','harga_hewan','persen_per_umur'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function pembelian_produk()
    {
        return $this->hasMany(PembelianProduk::class, 'ras_hewan_id');
    }

    public function jenis_hewan()
    {
        return $this->belongsTo(MasterJenisHewan::class, 'jenis_hewan_id');
    }
}
