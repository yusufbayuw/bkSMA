<?php

namespace App\Filament\Resources\PilihanResource\Pages;

use App\Filament\Resources\PilihanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPilihan extends ViewRecord
{
    protected static string $resource = PilihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(true),
        ];
    }
}
