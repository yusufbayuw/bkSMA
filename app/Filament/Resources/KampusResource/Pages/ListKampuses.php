<?php

namespace App\Filament\Resources\KampusResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\KampusResource;
use EightyNine\ExcelImport\ExcelImportAction;

class ListKampuses extends ListRecords
{
    protected static string $resource = KampusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}
