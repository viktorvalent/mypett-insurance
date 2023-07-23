<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBankMember extends Model
{
    protected $table = 'master_bank';
    protected $fillable = ['nama','deskripsi'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function member()
    {
        return $this->hasMany(Member::class, 'bank_id');
    }
}
