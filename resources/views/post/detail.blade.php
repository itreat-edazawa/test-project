@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="items-center">
            <img src="{{$user?->getProfileImageUrl() ?? Storage::disk('public')->url('profile_img/icon_user_light.png')}}" alt="プロフィール画像" class="w-50 h-50 rounded-full">
            <div class="text-lg text-gray-500">
                ユーザー名:{{ $user->name ?? '不明なユーザー' }}
            </div>
        </div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name ?? '不明なユーザー' }}の投稿一覧
        </h2>
    </x-slot>
    
        
    <div class="mx-auto px-6">
        <x-message :message="session('message')" />
        @foreach($posts as $post)
        <div class="mt-4 p-8 bg-white w-full rounded-2xl">
            <h1 class="p-4 text-lg font-semibold">
                件名:
                <a href="{{route('post.show', $post)}}" class="text-blue-600">
                    {{$post->title}}
                </a>
            </h1>
            <hr class="w-full">
            <p class="mt-4 p-4">
                {{$post->body}}
            </p>

            @foreach($post->images as $index => $image)
                @if($index % 2 == 0)
                    <div class = "flex">
                @endif
                <p class="m-2">
                    <img src="{{asset('storage/'.$image->name)}}" alt="{{$image->name}}">
                </p>
                @if($index % 2 != 0 or $loop->last)
                    </div>
                @endif
            @endforeach
            
            
            <div class="p-4 text-sm font-semibold flex">
                <p>
                    {{$post->created_at}} / 
                    <a href="{{route('post.detail',['user_id' => $post->user_id])}}" class="text-blue-600">
                        {{$post->user->name??'匿名'}}
                    </a>
                </p>
                @if($post->CheckLiked())
                <form method="POST" action="{{route('post.like')}}">
                    @csrf
                    <input type="hidden" name="posts_id" value="{{$post->id}}">
                    <button type="submit" class="text-gray-400 bg-red-200 cursor-pointer hover:text-gray-500 hover:bg-red-300 ml-5 rounded-md">
                        いいね
                    </button>
                </form>
                

                @else
                <form method="POST" action="{{route('post.unlike')}}">
                    @csrf
                    <input type="hidden" name="posts_id" value="{{$post->id}}">
                    <button type="submit" class="text-gray-500 bg-red-300 cursor-pointer hover:text-gray-400 hover:bg-red-200 ml-5 rounded-md">
                        いいね済
                    </button>
                </form>
                @endif

                <p class=ml-2>{{$post->likes->count() ?? '0'}}</p>
                <p>いいね</p>

            </div>
        </div>
    @endforeach
        <div class="mb-4">
            {{ $posts->links() }}
        </div>    
    </div>
</x-app-layout>
