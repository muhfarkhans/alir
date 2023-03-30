<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $table = 'citizens';

    protected $fillable = [
        'nik',
        'fullname',
        'address',
        'phone',
        'role'
    ];

    use HasFactory;
}
