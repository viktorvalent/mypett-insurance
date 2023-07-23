<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $fillable = ['user_id','bank_id','nama_lengkap','no_ktp','alamat','no_hp','no_rekening','kab_kota_id','profile_pic'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function master_bank()
    {
        return $this->belongsTo(MasterBankMember::class, 'bank_id');
    }

    public function kab_kota()
    {
        return $this->belongsTo(MasterKabKota::class, 'kab_kota_id');
    }

    public function pembelian_produk()
    {
        return $this->hasMany(PembelianProduk::class, 'member_id');
    }

    public function klaims()
    {
        return $this->hasMany(KlaimAsuransi::class, 'member_id');
    }
}
