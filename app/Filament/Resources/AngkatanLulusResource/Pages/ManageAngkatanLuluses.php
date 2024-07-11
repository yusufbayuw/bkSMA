<?php

namespace App\Filament\Resources\AngkatanLulusResource\Pages;

use App\Filament\Resources\AngkatanLulusResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAngkatanLuluses extends ManageRecords
{
    protected static string $resource = AngkatanLulusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
