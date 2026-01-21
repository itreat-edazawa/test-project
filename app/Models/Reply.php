<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'posts_id',
        'reply_user_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
