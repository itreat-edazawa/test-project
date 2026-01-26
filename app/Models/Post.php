<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->HasMany(Likes::class,'posts_id');
    }

    public function replies(){
        return $this->HasMany(Post::class,'posts_id');
    }

    public function images(){
        return $this->belongToMany(Image::class, 'post_images')
        ->using(PostImage::class);
    }

    public function CheckLiked(){
        $id = Auth::id();

        foreach($this->likes as $like){
            if($id==$like->user_id){
                return false;
            }
        }

        return true;
        
    }
}
