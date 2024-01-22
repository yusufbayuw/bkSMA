<?php

namespace App\Filament\Widgets;

use App\Models\Pengaturan;
use Filament\Widgets\Widget;

class BannerEligibleWidget extends Widget
{
    protected static string $view = 'filament.widgets.banner-widget';

    protected function getViewData(): array
    {
        $setting = Pengaturan::find(4)->nilai;
        $nama = Pengaturan::find(3)->nilai;

        return [
            'nama' => $nama,
            'setting' => $setting,
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['panel_user']);
    }
}
