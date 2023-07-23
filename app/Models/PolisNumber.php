<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolisNumber extends Model
{
    protected $table = 'polis_numbers';
    protected $fillable = ['tanggal_dibuat','nomor'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
