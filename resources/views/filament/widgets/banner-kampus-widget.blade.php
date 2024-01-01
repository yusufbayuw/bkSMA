@if ($pilihan && $setting)
<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $user = auth()->user();
        @endphp
        
            <div class="text-center text-sm text-gray-950">
                <span class="text-base text-primary-600 font-semibold">{{ explode(" ", $user->name)[0] }}</span>, Anda urutan ke-<span class="text-primary-600 font-bold">{{ $pilihan->ranking }}</span> dipilihan <span class="text-primary-600 font-bold">{{ $jurusan }}</span> ({{ $kampus }}).
            </div>
         
    </x-filament::section>
</x-filament-widgets::widget>
@else
<div class="hidden w-full fixed inset-x-0 bottom-0 z-50">
    <p></p>
</div>
@endif
