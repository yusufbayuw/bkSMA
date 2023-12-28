<x-filament-widgets::widget>
    <x-filament::section>
        @if ($pengumuman->content)
            <div class="flex items-center justify-center">
                <div class="">
                    <h1 class="text-center font-bold text-primary-900 text-2xl">PENGUMUMAN</h1>
                    {!! str_replace(
                        '<ol>',
                        '<ol class="list-disc list-inside">',
                        str_replace(
                            '<ul>',
                            '<ul class="list-disc list-inside">',
                            str_replace(
                                '<h3>',
                                '<h3 class="text-center font-bold text-lg">',
                                str_replace('<h2>', '<h2 class="text-center font-bold text-xl">', $pengumuman->content),
                            ),
                        ),
                    ) !!}
                </div>
            </div>
        @else
            <div class="flex items-center justify-center">
                <div class="text-center flex items-center justify-center text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>
                    <p>&nbsp;Tidak ada pengumuman.</p>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
