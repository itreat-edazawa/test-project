<div>
    <button wire:click="openModal" type="button" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xl text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        削除
    </button>

    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            本当に削除しますか？
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                一度消すと二度と復元できません
                            </p>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeModal" type="button" class="inline-flex justify-center w-full px-6 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm mt-3 sm:mt-0 sm:w-auto" >
                            やめる
                        </button>
                        <form wire:submit='delete'>
                            <button type="submit" class="inline-flex justify-center w-full px-6 py-2 text-base font-medium text-white bg-red-500 hover:bg-red-400 border border-gray-300 rounded-md shadow-sm mt-3 sm:mt-0 sm:w-auto absolute left-3" >
                                削除する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


