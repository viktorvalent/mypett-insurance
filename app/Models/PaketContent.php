<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketContent extends Model
{
    protected $table = 'paket_content';
    protected $fillable = ['nama','warna','icon','harga','produk_id'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function produk_asuransi()
    {
        return $this->belongsTo(ProdukAsuransi::class, 'produk_id');
    }
}
