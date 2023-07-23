<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfirmasiKlaimAsuransi extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_klaim_asuransi';
    protected $fillable = ['klaim_id','alasan','nominal_ditawarkan','nominal_bayar_rs','nominal_bayar_obat','nominal_bayar_dokter'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function klaim_asuransi()
    {
        return $this->belongsTo(KlaimAsuransi::class, 'klaim_id');
    }
}
