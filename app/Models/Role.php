<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = ['nama_role'];
    public $timestamps = true;
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasMany(User::class, 'role');
    }
}
