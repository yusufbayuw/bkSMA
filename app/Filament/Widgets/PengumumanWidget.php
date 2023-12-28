<?php

namespace App\Filament\Widgets;

use App\Models\Pengumuman;
use Filament\Widgets\Widget;

class PengumumanWidget extends Widget
{
    protected static string $view = 'filament.widgets.pengumuman-widget';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $pengumuman = Pengumuman::find(1);

        return ['pengumuman' => $pengumuman,];
    }
}
