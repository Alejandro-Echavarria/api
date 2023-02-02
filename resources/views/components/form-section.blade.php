<div {{ $attributes->merge(["class" => "md:grid md:grid-cols-3 md:gap-6"]) }}>
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium">{{ $title }}</h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div>
            <div class="px-4 py-5 sm:p-6">
                {{ $slot }}
            </div>

            @isset($actions)
                <div class="px-6 py-3 flex justify-end items-center">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    </div>
</div>