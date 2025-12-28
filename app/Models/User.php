<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_telp',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
