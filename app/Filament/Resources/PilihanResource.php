<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Pilihan;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PilihanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\PilihanResource\RelationManagers;

class PilihanResource extends Resource
{
    protected static ?string $model = Pilihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $navigationLabel = 'Pilihan';

    protected static ?string $slug = 'pilihan';

    public static function getEloquentQuery(): Builder
    {
        $userAuth = auth()->user();
        if ($userAuth->hasRole(['super_admin', 'admin_pusat'])) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', $userAuth->id);
        }
    }

    public static function form(Form $form): Form
    {
        $userAuth = auth()->user();
        $userAuthCanChange = $userAuth->is_can_choose;
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('users', 'name',  modifyQueryUsing: fn (Builder $query) => ($userAuth->hasRole(['super_admin'])) ? $query : $query->where('id',$userAuth->id))
                    ->default($userAuth->id)
                    ->label('Nama Siswa')
                    ->disabled(!$userAuthCanChange)
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Select::make('kampus_id')
                    ->relationship('kampuses', 'nama_kampus')
                    ->searchable()
                    ->label('Pilih Kampus')
                    ->disabled(!$userAuthCanChange)
                    ->preload()
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('jurusan_id')
                    ->label('Pilih Jurusan')
                    ->disabled(!$userAuthCanChange)
                    ->relationship('jurusans', 'nama_jurusan', modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('kampus_id', $get('kampus_id')))
                    ->columnSpanFull()
                    ->required(),
                Hidden::make('nilai')->default(fn () => User::find($userAuth->id)->nilai),
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
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('jurusan_id', 'asc')->orderBy('nilai', $direction)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->hidden(!$userAuth->hasRole(['super_admin', 'guru_bk'])),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kampuses.nama_kampus')
                    ->label('Kampus')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusans.nama_jurusan')
                    ->label('Jurusan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->sortable(),
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
                Tables\Actions\EditAction::make()->hidden(!auth()->user()->is_can_choose),
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
            'index' => Pages\ListPilihans::route('/'),
            'create' => Pages\CreatePilihan::route('/create'),
            'view' => Pages\ViewPilihan::route('/{record}'),
            'edit' => Pages\EditPilihan::route('/{record}/edit'),
        ];
    }
}
