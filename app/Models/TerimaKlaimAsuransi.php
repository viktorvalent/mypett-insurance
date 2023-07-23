<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerimaKlaimAsuransi extends Model
{
    protected $table = 'terima_klaim_asuransi';
    protected $fillable = ['klaim_id','bukti_bayar_klaim','keterangan_alasan'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function klaim_asuransi()
    {
        return $this->belongsTo(KlaimAsuransi::class, 'klaim_id');
    }
}
