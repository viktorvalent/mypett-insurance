<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{
    protected $table = 'master_bank_payment';
    protected $fillable = ['nama','logo','deskripsi'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function nomor_rekening_bank()
    {
        return $this->hasMany(NomorRekeningBank::class, 'bank_id');
    }
}
