<?php

namespace App\Filament\Resources\PilihanResource\Pages;

use App\Filament\Resources\PilihanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPilihan extends EditRecord
{
    protected static string $resource = PilihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
