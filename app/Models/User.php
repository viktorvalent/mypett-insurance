<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['username','email','password','role'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'user_id');
    }
}
