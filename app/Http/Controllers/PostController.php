<?php

namespace App\Http\Controllers;

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

use Illuminate\Http\Request;

use Carbon\Carbon;

class PostController extends Controller
{
    public function create(){
        return view('post.create');
    }

   

    public function search(Request $request){

        $time_fn_chk = $request['time_fn'];

        $validated = $request->validate([


            'username' => 'nullable|string|max:20',
            'title' => 'nullable|string|max:30',
            'user_id' => 'nullable|integer|max:20',
            'freeword' => 'nullable|string|max:250',

            'time_st' => 'nullable|date|before_or_equal:'.Carbon::parse($time_fn_chk)->format('Y-m-d'),
            'time_fn' => 'nullable|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),


            

        ],[
            
        ]);

        $posts = Post::query();
        $sort_id = $request['sort_id'] ?? '0';

        
        
        if(!empty($request['sort_id'])){
            

            if($sort_id=='newest'){
                $posts = Post::latest();
            }
            else if($sort_id=='oldest'){
                $posts = Post::oldest();
            }
            
            else if($sort_id=='most likes'){
                $posts = $posts->withCount('likes')->orderby('likes_count','desc');
            }
            else if($sort_id=='least likes'){
                $posts = $posts->withCount('likes')->orderby('likes_count','asc');
            }

       

        
        }
        else{
            $posts->latest();
        }
        

        $username = $validated['username'] ?? '';
        $title = $validated['title'] ?? '';
        $user_id = $validated['user_id'] ?? '';
        $freeword = $validated['freeword'] ?? '';
        $time_st = $validated['time_st'] ?? '';
        $time_fn = $validated['time_fn'] ?? '';

        

        //if文　空の時は全検索
        if(!empty($user_id)){
            $posts = $posts->where('user_id',$user_id);
        }

        if(!empty($username)){
            $posts = $posts->join('users','posts.user_id','=','users.id')
                     ->select('posts.*')
                     ->where('name', 'LIKE', '%' .$username. '%');
        }

        if(!empty($title)){
            $posts = $posts->where('title','LIKE', '%' .$title. '%');
        }

        if(!empty($freeword)){
            $posts = $posts->where('body','LIKE', '%' .$freeword. '%');
        }
       
        if(!empty($time_st)){
            $posts = $posts->where('posts.created_at', '>=', $time_st);
        }

        if(!empty($time_fn)){
            $posts = $posts->where('posts.created_at', '<=', $time_fn);
        }



        

        $posts = $posts->paginate(10);

        return view('post.index', compact('posts'));
        
    }
    
    
    public function store(Request $request){
        Gate::authorize('test');


        $validated = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:400',
        ]);

        $imagefiles = $request->file('images');
        $image_ids = [];

        if(!empty($imagefiles)){
            $tmp = 0;

            foreach($imagefiles as $imagefile){
               $imagefilepath = $imagefile->store('post_image','public');
               $image = Image::create([
                'name' => $imagefilepath
               ]);
               $image_ids[$tmp] = $image->id;

               $tmp++;
            }
        }

        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);

        $post_id = $post->id;

        foreach($image_ids as $image_id){
            $post_image = PostImage::create([
                'post_id' => $post_id,
                'image_id' => $image_id,
            ]);
        }

        $request->session()->flash('message', '保存しました');

        return redirect()->route('post.index');
    }

    public function index(Request $request){

        
        
        $posts=Post::paginate(10)->withCount('likes');
        
        return view('post.index', compact('posts'));
    }

    public function show (Post $post) {
        $replies = Reply::where('posts_id',$post['id'])
        ->latest()
        ->paginate();

        return view('post.show', compact('post','replies'));

        
    }

    public function edit(Post $post) {
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, Post $post){
        $validated = $request->validate([
            'title' => 'required|max:20',
            'body' => 'required|max:400',
        ]);

        $validated['user_id'] = auth()->id();

        $post->update($validated);

        $request->session()->flash('message', '更新しました');
        return redirect()->route('post.show', compact('post'));
    }

    public function destroy(Request $request,Post $post) {
        $post->delete();
        $request->session()->flash('message', '削除しました');
        return redirect()->route('post.index');
    }

    public function detail(String $user_id){
        $posts = Post::query()->where('user_id',$user_id)
                ->latest()
                ->paginate(10);
        
        $user = User::where('id',$user_id)->first();
                
        return view('post.detail',compact('posts','user_id','user'));



    }

    public function like(Request $request){
        $posts_id = $request->input('posts_id');
        if(Auth::check()){
            $user = Auth::user();

            $user_id = $user['id'];

            $like = Likes::create([
                'posts_id' => $posts_id,
                'user_id' => $user_id
            ]);
            

            
        }

        
        
        return back();
    }

    public function unlike(Request $request){
        $posts_id = $request->input('posts_id');
        if(Auth::check()){
            $like = Likes::where('posts_id',$posts_id)->where('user_id',Auth::id());
            $like->delete();

            
        }

        return back();
    }

    
    

    public function PostDownloadCsv(Request $request){
        
        $time_fn_chk = $request['time_fn'];

        $validated = $request->validate([


            'username' => 'nullable|string|max:20',
            'title' => 'nullable|string|max:30',
            'user_id' => 'nullable|integer|max:20',
            'freeword' => 'nullable|string|max:250',

            'time_st' => 'nullable|date|before_or_equal:'.Carbon::parse($time_fn_chk)->format('Y-m-d'),
            'time_fn' => 'nullable|date|before_or_equal:'.Carbon::now()->format('Y-m-d'),

        ],[
            
        ]);

        $posts = Post::query();
        $sort_id = $request['sort_id'] ?? '0';
        if(!empty($request['sort_id'])){
            

            if($sort_id=='newest'){
                $posts = Post::latest();
            }
            else if($sort_id=='oldest'){
                $posts = Post::oldest();
            }
            //いいねの数把握
            else if($sort_id=='most likes'){
                $posts = $posts->withCount('likes')->orderby('likes_count','desc');
            }
            else if($sort_id=='least likes'){
                $posts = $posts->withCount('likes')->orderby('likes_count','asc');
            }

       

        
        }
        else{
            $posts = $posts->latest();
        }
        

        $username = $validated['username'] ?? '';
        $title = $validated['title'] ?? '';
        $user_id = $validated['user_id'] ?? '';
        $freeword = $validated['freeword'] ?? '';
        $time_st = $validated['time_st'] ?? '';
        $time_fn = $validated['time_fn'] ?? '';

        

        //if文　空の時は全検索
        if(!empty($user_id)){
            $posts = $posts->where('user_id',$user_id);
        }

        if(!empty($username)){
            $posts = $posts->join('users','posts.user_id','=','users.id')
                     ->select('posts.*')
                     ->where('name', 'LIKE', '%' .$username. '%');
        }

        if(!empty($title)){
            $posts = $posts->where('title','LIKE', '%' .$title. '%');
        }

        if(!empty($freeword)){
            $posts = $posts->where('body','LIKE', '%' .$freeword. '%');
        }
       
        if(!empty($time_st)){
            $posts = $posts->where('posts.created_at', '>=', $time_st);
        }

        if(!empty($time_fn)){
            $posts = $posts->where('posts.created_at', '<=', $time_fn);
        }

        $posts = $posts->get();
        $csvHeader = ['ポストID','ユーザーID','タイトル','内容','いいね数','ポスト日','最終更新日'];
        

        $response = new StreamedResponse(function() use ($csvHeader, $posts){
            
            $handle = fopen('php://output','w');
            //BOMの追加<-これがないと文字化け
            fprintf($handle,"\xEF\xBB\xBF");
            fputcsv($handle,$csvHeader);

            foreach($posts as $post){
                $row = [
                    $post->id,
                    $post->user_id,
                    $post->title,
                    $post->body,
                    $post->like_sum,
                    $post->created_at,
                    $post->updated_at,

                ];
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $data_time = Carbon::now();
        
        $response->headers->set('Content-Type','text/csv');
        $response->headers->set('Content-Disposition','attachment; filename="posts/"'.$data_time.'".csv"');
        

        return $response;

    }

    
    public function reply_view(Post $post){
        
        return view('post.reply',compact('post'));
    }

    public function reply(Request $request,Post $post){
        $validated=$request->validate([
            'body' => 'required|max:400',
        ]);
        $validated['reply_user_id'] = auth()->id();

        $posts_id = $post->id;

        $replies = Reply::create([
            'body' => $validated['body'],
            'posts_id' => $posts_id,
            'reply_user_id' => $validated['reply_user_id'],
        ]);

        return redirect()->route('post.show',compact('post'));

    }

    
    
}
