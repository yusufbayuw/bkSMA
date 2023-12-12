<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Jurusan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JurusanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\JurusanResource\RelationManagers;

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?string $navigationLabel = 'Jurusan';

    protected static ?string $slug = 'jurusan';

    public static function form(Form $form): Form
    {
        $userAuth = auth()->user();
        return $form
            ->schema([
                Forms\Components\Select::make('kampus_id')
                    ->label('Nama Kampus')
                    ->required()
                    ->relationship('kampuses', 'nama_kampus'),
                Forms\Components\TextInput::make('nama_jurusan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $userAuth = auth()->user();
        return $table
            ->groups([
                Group::make('kampuses.nama_kampus')
                    ->titlePrefixedWithLabel(false)
                    ->label('Kampus')
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
                Tables\Columns\TextColumn::make('kampuses.nama_kampus')
                    ->label('Kampus')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_jurusan')
                    ->label('Jurusan')
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
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'view' => Pages\ViewJurusan::route('/{record}'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
        ];
    }
}
