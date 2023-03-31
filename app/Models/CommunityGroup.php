<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    protected $table = 'community_groups';

    protected $fillable = [
        'name',
        'address',
    ];

    use HasFactory;
}