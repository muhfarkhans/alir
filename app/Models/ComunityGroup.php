<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunityGroup extends Model
{
    protected $table = 'comunity_groups';

    protected $fillable = [
        'name',
        'address',
    ];

    use HasFactory;
}
