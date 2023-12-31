@if (auth()->user()->eligible)    
<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $user = auth()->user();
        @endphp
        @if ($user->eligible)
            <div class="text-center text-sm text-gray-950">
                <span class="text-base text-primary-600 font-semibold">Selamat {{ explode(" ", $user->name)[0]." (".$user->kelas.")" }}</span>, Anda masuk kuota <span class="text-primary-600 font-bold">eligible</span> peringkat ke-<span class="text-primary-600 font-bold">{{ $user->ranking }}</span> kelompok <span class="text-primary-600 font-bold">{{ $user->program }}</span> dengan nilai rata-rata <span class="text-primary-600 font-bold">{{ $user->nilai }}</span>
            </div>
        @endif
        
    </x-filament::section>
</x-filament-widgets::widget>
@endif
