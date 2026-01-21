<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        
        <div class="bg-white w-full rounded-2xl mb-1">
            <div class="mt-4 p-4">
                <h1 class="text-lg font-semibold">
                    {{$post->title}}
                </h1>
                <!--id一致しているユーザーのみ編集可能-->    
                @can('edit-post', $post)
                <div class="text-right flex">
                    <a href="{{route('post.edit', $post)}}" class="flex-1">
                        <x-primary-button>
                            編集
                        </x-primary-button>
                    </a>

                    <form method="post" action="{{route('post.destroy',$post)}}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-primary-button class="bg-red-700 ml-2">
                            削除
                        </x-primary-button>
                    </form>
                </div>
                @endcan
                <hr class="w-full">
                <p class="mt-4 whitespace-pre-line">
                    {{$post->body}}
                </p>
            <div class="text-sm font-semibold flex flex-row-reverse">
                <p>
                    {{$post->created_at}}
                </p>
            </div>
        </div>

        
   
    </div>
    @can('reply-post')
        <a href="{{route('post.replyview',$post)}}">
            <x-primary-button>
                返信
            </x-primary-button>
        </a>
    @endcan
    <div class="ml-5 mr-5">
        @foreach($replies as $reply)
            <div class="mb-5">
                <div class="bg-white  rounded-2xl mb-1">
                    <div class="mt-4 p-4">
                        
                        <h1 class="text-lg font-semibold">
                            {{$reply->reply_user_id}}
                        </h1>

                        <p class="mt-4 whitespace-pre-line">
                            {{$reply->body}}
                        </p>
                    <div class="text-sm font-semibold flex flex-row-reverse">
                        <p>
                            {{$reply->created_at}}
                        </p>
                    </div>
                </div>
            </div>
    @endforeach
    </div>



</x-app-layout>
