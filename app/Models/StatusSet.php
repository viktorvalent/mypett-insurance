<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusSet extends Model
{
    protected $table = 'status_set';
    protected $fillable = ['status'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function pembelian_produk()
    {
        return $this->hasMany(PembelianProduk::class, 'status');
    }

    public function klaim_asuransi()
    {
        return $this->hasMany(KlaimAsuransi::class, 'status_klaim');
    }
}
