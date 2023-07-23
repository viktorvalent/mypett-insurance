<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'hero';
    protected $fillable = ['nama','logo','deskripsi'];
    public $timestamps = true;
    protected $primaryKey = 'id';
}
