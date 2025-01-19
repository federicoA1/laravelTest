<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'comment',
        'like_count',
    ];

    public function comment()
    {
        return $this->belongsTo(CommunityPosts::class);
    }
}
