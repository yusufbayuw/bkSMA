<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UserResource;
use App\Imports\MyUserCreateImport;
use App\Imports\MyUserImport;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Models\User;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $userAuth = auth()->user();
        return [
            ExcelImportAction::make('update')
                ->label('Update')
                ->icon('heroicon-o-arrow-path')
                ->color("success")
                ->use(MyUserImport::class)
                ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
            ExcelImportAction::make('import')
                ->color("info")
                ->icon('heroicon-o-arrow-up-tray')
                ->use(MyUserCreateImport::class)
                ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
            // add button to update user role to panel_user
            Actions\Action::make('updateRole')
                ->label('Update Role')
                ->icon('heroicon-o-user-plus')
                ->color('primary')
                ->action(function () {
                    $users = User::all();
                    foreach ($users as $user) {
                        $user->assignRole('panel_user');
                    }
                })
                ->hidden(!$userAuth->hasRole(['super_admin'])),
            Actions\CreateAction::make(),
        ];
    }
}
