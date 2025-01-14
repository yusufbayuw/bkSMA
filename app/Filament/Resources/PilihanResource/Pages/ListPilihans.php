<?php

namespace App\Filament\Resources\PilihanResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Pilihan;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PilihanResource;

class ListPilihans extends ListRecords
{
    protected static string $resource = PilihanResource::class;

    protected function getHeaderActions(): array
    {
        $userAuth = auth()->user();
        return [
            Actions\Action::make('Reload')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->action(function () {
                    User::whereNotNull('program')->update(['is_can_choose' => true]);

                    // ranking pilihan
                    $rankedData = DB::table('pilihans')
                        ->select('id', 'nilai', 'jurusan_id')
                        ->selectRaw('ROW_NUMBER() OVER (PARTITION BY jurusan_id ORDER BY nilai DESC) as rank')
                        ->get();

                    foreach ($rankedData as $data) {
                        // Update the Pilihan model with the calculated ranking
                        Pilihan::where('id', $data->id)->update(['ranking' => $data->rank]);
                    }
                })->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
            Actions\CreateAction::make(),//->hidden($userAuth->is_choosed),
        ];
    }
}
