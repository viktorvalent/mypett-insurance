<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlaimAsuransi extends Model
{
    protected $table = 'klaim_asuransi';
    protected $fillable = ['tgl_klaim','status_klaim','member_id','polis_id','history_klaim','foto_bukti_bayar','foto_resep_obat','foto_diagnosa_dokter','nominal_bayar_rs','nominal_bayar_dokter','nominal_bayar_obat','nominal_disetujui','keterangan_klaim'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function polis()
    {
        return $this->belongsTo(PolisAsuransi::class, 'polis_id');
    }

    public function status_set()
    {
        return $this->belongsTo(StatusSet::class, 'status_klaim');
    }

    public function tolak_klaim_asuransi()
    {
        return $this->hasOne(TolakKlaimAsuransi::class, 'klaim_id');
    }

    public function terima_klaim_asuransi()
    {
        return $this->hasOne(TerimaKlaimAsuransi::class, 'klaim_id');
    }

    public function konfirmasi_klaim_asuransi()
    {
        return $this->hasOne(KonfirmasiKlaimAsuransi::class, 'klaim_id');
    }

    public function limit_confirmation_klaim()
    {
        return $this->hasOne(LimitConfirmationKlaim::class, 'klaim_id');
    }
}
