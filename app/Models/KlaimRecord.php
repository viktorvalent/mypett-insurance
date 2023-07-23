<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaimRecord extends Model
{
    use HasFactory;
    protected $table = 'klaim_records';
    protected $fillable = ['tgl_klaim_disetujui','total_klaim_disetujui','polis_id'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function polis()
    {
        return $this->belongsTo(PolisAsuransi::class, 'polis_id');
    }
}
