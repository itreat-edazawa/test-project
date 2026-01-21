<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ようこそ') }}
        </h2>
    </x-slot>

    <div>
        <div class="text-2xl p-5 text-center bg-slate-50 text-gray-900">
            <p>{{'今日の人気な投稿'}}</p>
        </div>
    </div>
</x-app-layout>
