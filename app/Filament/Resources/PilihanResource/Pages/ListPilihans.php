<?php

namespace App\Filament\Resources\PilihanResource\Pages;

use App\Filament\Resources\PilihanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPilihans extends ListRecords
{
    protected static string $resource = PilihanResource::class;

    protected function getHeaderActions(): array
    {
        $userAuth = auth()->user();
        return [
            Actions\CreateAction::make()->hidden($userAuth->is_choosed),
        ];
    }
}
