<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetshopTerdekat extends Model
{
    protected $table = 'petshop_terdekat';
    protected $fillable = ['nama_petshop','keterangan_petshop','gmaps_iframe','kab_kota_id','alamat'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function kab_kota()
    {
        return $this->belongsTo(MasterKabKota::class, 'kab_kota_id');
    }
}
