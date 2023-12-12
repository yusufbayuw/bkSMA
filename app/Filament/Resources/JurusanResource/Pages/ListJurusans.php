<?php

namespace App\Filament\Resources\JurusanResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\JurusanResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ListJurusans extends ListRecords
{
    protected static string $resource = JurusanResource::class;

    protected function getHeaderActions(): array
    {
        $userAuth = auth()->user();
        return [
            ExcelImportAction::make()
                ->color("primary")
                ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk']))
                ->icon('heroicon-o-arrow-up-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
