<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
