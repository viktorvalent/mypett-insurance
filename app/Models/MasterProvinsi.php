<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProvinsi extends Model
{
    protected $table = 'master_provinsi';
    protected $fillable = ['nama','deskripsi'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function kab_kota()
    {
        return $this->hasMany(MasterKabKota::class, 'provinsi_id');
    }
}
