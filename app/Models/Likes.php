<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = ['posts_id','user_id'];

    public function post(){
        return $this->belongTo(Post::class);
    }

    public function user(){
        return $this->belongTo(User::class);
    }

}
