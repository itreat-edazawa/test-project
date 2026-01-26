<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostImage extends Pivot
{
    protected $table = 'post_images';

    protected $fillable = [
        'post_id',
        'image_id',
    ];
}
