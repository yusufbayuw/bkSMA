<?php

namespace App\Filament\Resources\PilihanResource\Pages;

use App\Filament\Resources\PilihanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePilihan extends CreateRecord
{
    protected static string $resource = PilihanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
