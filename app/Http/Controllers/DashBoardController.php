<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Http\Requests\UploadImageRequest;

use App\Models\Post;
use App\Models\User;
use App\Models\Likes;
use App\Models\Reply;
use App\Models\Image;
use App\Models\PostImage;

use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index(Request $request){

        $posts = Post::query();

        

    }
}
