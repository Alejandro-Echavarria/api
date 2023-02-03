@props(['modal'])

{{-- Modal --}}
<div v-show="{{ $modal }}" class="relative z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div v-on:click="{{$modal}} = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="w-full flex min-h-full justify-center p-4 text-center items-center">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all my-8 w-full max-w-lg">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-start">
                        <div class="w-full text-left">
                            <div class="flex">
                                <h3 class="text-lg font-semibold leading-6 text-gray-800 dark:text-gray-200" id="modal-title">
                                    {{ $title }}
                                </h3>
                                <button v-on:click="{{ $modal }} = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="mt-2">
                                {{ $content }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    {{ $footer }}
                </div>
            </div>
        </div>
    </div>
</div>
