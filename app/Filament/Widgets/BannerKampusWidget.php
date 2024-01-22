<?php

namespace App\Filament\Widgets;

use App\Models\Kampus;
use App\Models\Jurusan;
use App\Models\Pilihan;
use App\Models\Pengaturan;
use Filament\Widgets\Widget;

class BannerKampusWidget extends Widget
{
    protected static string $view = 'filament.widgets.banner-kampus-widget';

    protected function getViewData(): array
    {
        $setting = Pengaturan::find(5)->nilai;
        $pilihan = Pilihan::where('user_id', auth()->user()->id)->first();

        $kampus = '';
        $jurusan = '';

        if ($pilihan) {
            $kampus = Kampus::find($pilihan->kampus_id)->nama_kampus;
            $jurusan = Jurusan::find($pilihan->jurusan_id)->nama_jurusan;
        }

        return [
            'pilihan' => $pilihan,
            'setting' => $setting,
            'kampus' => $kampus,
            'jurusan' => $jurusan,
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['panel_user']);
    }
}
