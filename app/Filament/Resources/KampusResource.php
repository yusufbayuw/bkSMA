<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KampusResource\Pages;
use App\Filament\Resources\KampusResource\RelationManagers;
use App\Models\Kampus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('lokasi_kampus')
                    ->label('Lokasi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kampus')
                    ->label('Nama Kampus')
                    ->searchable(),
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
