<head>
    {{-- <!--@vite(['resources/css/index.css'])!--> --}}
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            <p>一覧表示</p>

            <a href="{{route('post.csvdownload',request()->query())}}" class="hover:cursor-pointer hover:text-blue-400 text-gray-800 csv_pos absolute right-5">CSV出力</a>
        </h2>
        
    </x-slot>
    <div class="bg-gray-50 px-10 py-10 m-2">
        <div class="bg-gray-400 p-3 mr-5 ml-5">検索</div>
        <form method="get" action="{{ route('post.index')}}">
            
            <div class="m-2 flex">
                <div class="bg-blue-50 p-2 mx-5">
                    <p>ユーザー名</p>
                    <!--TODO:usernameを書いたものに変更 !-->
                    <x-input-error :messages="$errors->get('username')" class="mt-2"/>
                    <input type="text" name="username" id="username" value="{{request('username')}}">
                </div>
                <div class="bg-red-50 p-2 mx-5">
                    <p>タイトル</p>
                    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                    <input type="text" name="title" id="title" value="{{request('title')}}">
                </div>
                <div class="bg-green-50 p-2 mx-5">
                    <p>ユーザーID</p>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2"/>
                    <input type="text" name="user_id" id="user_id" value="{{request('user_id')}}">
                </div>
            </div>
            <div class="bg-slate-50 p-2 m-3 flex">
                <div class="pr-48 ml-4">
                    <p>フリーワード検索</p>
                    <x-input-error :messages="$errors->get('freeword')" class="mt-2"/>
                    <input type="text" name="freeword" id="freeword" value="{{request('freeword')}}" class="pr-48">
                </div>
            </div>
    
            <div class="m-2 flex">
                <div class="p-2 mx-5">
                    <p>日時範囲検索
                    <div class="flex">
                        <div>
                            <x-input-error :messages="$errors->get('time_st')" class="mt-2"/>
                            <input type="date" name="time_st" id="time_st" value="{{request('time_st')}}" class="w-40 h-5">
                        </div>

                        <p class="mx-10 py-2">から</p>
                        <div>
                            <x-input-error :messages="$errors->get('time_fn')" class="mt-2"/>
                            <input type="date" name="time_fn" id="time_fn" value="{{request('time_fn')}}" class="w-40 h-5">
                        </div>
                        
                    </div>
                </div>
                <div class="p-2 mx-5">
                    <p>並び替え</p>
                    <select class = "form-select" id="sort" name="sort_id">
                        <option value="">選択してください</option>
                        <option value="newest" @selected(request('sort_id') == 'newest')>新しい順</option>
                        <option value="oldest" @selected(request('sort_id') == 'oldest')>古い順</option>
                        <option value="most likes" @selected(request('sort_id') == 'most likes')>いいね多い順</option>
                        <option value="least likes" @selected(request('sort_id') == 'least likes')>いいね少ない順</option>
                    </select>
                </div>
            </div>
            <x-primary-button class="mt-4 ml-5">
                検索する
            </x-primary-button>
        </form>
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
                    <a href="{{route('post.detail',['user_id' => $post->user_id??'0'])}}" class="text-blue-600">
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
