<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolisKlaimParsial extends Model
{
    use HasFactory;
    protected $table = 'polis_klaim_parsials';
    protected $fillable = ['tgl_mulai','tgl_berakhir','polis_id','limit_klaim'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function polis()
    {
        return $this->belongsTo(PolisAsuransi::class, 'polis_id');
    }
}
