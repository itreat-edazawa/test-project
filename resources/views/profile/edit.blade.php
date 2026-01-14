<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p>プロフィール画像</p>
                    <form  action="{{route('profile.store')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="file" name="profile_imagepath" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <input type="submit" value="アップロード" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-blue-400">
                    </form>
                    @if(session('message'))
                        <div class="text-red-600 font-bold">
                            {{session('message')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p>現在の好きな食べ物</p>
                    <p>{{$favorite_food}}</p>
                    <p>好きな食べ物を選んでね</p>
                    <form method="post" action="{{route('profile.favfood')}}">
                        @csrf
                        <select class = "form-select" id="favorite_food" name="favorite_food">
                            <option value="">選択してください</option>
                            @foreach ($foods as $index => $name)
                                <option value="{{$index}}">{{$name}}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="登録する" class="bg-slate-500 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-slate-400 ml-10">
                    </form>

                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
