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
        'market_id'
    ];

    use HasFactory;

    public function market()
    {
        return $this->hasOne(Market::class, 'id', 'market_id');
    }
}

