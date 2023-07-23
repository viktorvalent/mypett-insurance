<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TolakKlaimAsuransi extends Model
{
    protected $table = 'tolak_klaim_asuransi';
    protected $fillable = ['klaim_id','alasan_menolak'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function klaim_asuransi()
    {
        return $this->belongsTo(KlaimAsuransi::class, 'klaim_id');
    }
}
