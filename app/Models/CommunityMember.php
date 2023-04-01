<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    use HasFactory;

    protected $table = 'community_members';

    protected $fillable = [
        'community_group_id',
        'citizen_id',
        'gurantor_citizen_id',
        'role',
    ];

    public function citizen()
    {
        return $this->hasOne(Citizen::class, 'id', 'citizen_id');
    }

    public function gurantor_citizen()
    {
        return $this->hasOne(Citizen::class, 'id', 'gurantor_citizen_id');
    }
}