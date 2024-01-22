<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->user()->id),
                Forms\Components\TextInput::make('nama')
                    ->default(auth()->user()->name)
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\Hidden::make('starts_at'),
                Forms\Components\Hidden::make('ends_at'),//->live()->afterStateUpdated(fn ($state) => dd($state))->closeOnDateSelection(),
                Forms\Components\DatePicker::make('start_date')
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $time = $get('start_time');
                        $date = explode(' ',$state)[0];
                        if ($time) {
                            $set('starts_at', Carbon::parse($date . 'T' . $time));
                            $set('ends_at', Carbon::parse($date . 'T' . $time)->addHour());
                        }
                    })
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->minDate(now())
                    ->closeOnDateSelection()
                    ->weekStartsOnSunday()
                    ->live(),
                Forms\Components\Select::make('start_time')
                    //->native(false)    
                    ->options(function (Get $get) {
                        $timelist = [
                            '07:00:00' => '07:00',
                            '08:00:00' => '08:00',
                            '09:00:00' => '09:00',
                            '10:00:00' => '10:00',
                            '11:00:00' => '11:00',
                            '13:00:00' => '13:00',
                            '14:00:00' => '14:00',
                        ];
                        if ($get('start_date')) {
                            $occupied = Event::where('start_date', $get('start_date'))->select('start_time')->get()->pluck('start_time')->toArray() ?? [];
                            $timelist = array_diff($timelist, $occupied);
                        }
                        return $timelist;
                    })
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $date = explode(' ', $get('start_date'))[0];
                        $time = $state;
                        if ($date) {
                            
                            $set('starts_at', Carbon::parse($date . 'T' . $time));
                            $set('ends_at', Carbon::parse($date . 'T' . $time)->addHour());
                        }   
                    })
                    ->required()
                    ->hidden(fn (Get $get) => $get('start_date') === null)
                    ->live(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time'),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'), 
        ];
    }
}
