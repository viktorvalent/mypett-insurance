<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJenisHewan extends Model
{
    protected $table = 'master_jenis_hewan';
    protected $fillable = ['nama','deskripsi'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function ras_hewan()
    {
        return $this->hasMany(MasterRasHewan::class, 'jenis_hewan_id');
    }
}
