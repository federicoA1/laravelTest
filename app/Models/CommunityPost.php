<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'like_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comment(){
        return $this->HasMany(Comments::class);
    }
}
