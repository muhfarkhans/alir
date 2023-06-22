<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $table = 'markets';

    protected $fillable = [
        'name',
        'address',
    ];

    use HasFactory;
}
