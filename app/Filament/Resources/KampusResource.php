<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kampus;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KampusResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\KampusResource\RelationManagers;

class KampusResource extends Resource
{
    protected static ?string $model = Kampus::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?string $navigationLabel = 'Kampus';

    protected static ?string $slug = 'kampus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kampus')
                    ->label('Nama Kampus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jenis')
                    ->options([
                        "PT Negeri" => "PT Negeri",
                        "PT Swasta" => "PT Swasta",
                        "PT Luar Negeri" => "PT Luar Negeri"
                    ]),
                Forms\Components\TextInput::make('lokasi_kampus')
                    ->label('Lokasi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userAuth = auth()->user();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
                Tables\Columns\TextColumn::make('nama_kampus')
                    ->label('Nama Kampus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->sortable()
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('lokasi_kampus')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKampuses::route('/'),
            'create' => Pages\CreateKampus::route('/create'),
            'view' => Pages\ViewKampus::route('/{record}'),
            'edit' => Pages\EditKampus::route('/{record}/edit'),
        ];
    }
}
