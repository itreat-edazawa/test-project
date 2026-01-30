<x-app-layout>
    <div class="w-full bg-slate-50 mx-10">
        <div class="my-2 text-3xl text-center">
            <p>{{"403エラー:このサイトに入る権限はありません"}}</p>
        </div>
        <div class="text-center">
            <button class="m-10 py-4 px-6 bg-green-400 hover:bg-green-300 text-gray-600 hover:text-gray-500 rounded text-xl" type="button" onclick="location.href='{{route('post.index')}}'" >
                {{"投稿一覧に戻る"}}
            </button>
        </div>
    </div>
</x-app-layout>