<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni';
    protected $fillable = ['nama','pekerjaan','testi_text','foto'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
