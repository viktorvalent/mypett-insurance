<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitConfirmationKlaim extends Model
{
    use HasFactory;

    protected $table = 'limit_confirmation_klaim';
    protected $fillable = ['klaim_id','alasan','nominal_limit','nominal_pengajuan','nominal_ditawarkan'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function klaim_asuransi()
    {
        return $this->belongsTo(KlaimAsuransi::class, 'klaim_id');
    }
}
