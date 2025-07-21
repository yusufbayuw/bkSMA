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
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $modelLabel = 'Konsultasi';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?string $navigationLabel = 'Konsultasi';

    protected static ?string $slug = 'konsultasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->user()->id),
                TextInput::make('nama')
                    ->label('Nama Siswa')
                    ->default(auth()->user()->name)
                    ->readOnly(),
                Hidden::make('starts_at'),
                Hidden::make('ends_at'),
                DatePicker::make('start_date')
                    ->label('Pilih Tanggal Konsultasi')
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $time = $get('start_time');
                        $date = Carbon::parse($state)->format('Y-m-d');
                        if ($time) {
                            $set('starts_at', Carbon::parse($date . 'T' . $time));
                            $set('ends_at', Carbon::parse($date . 'T' . $time)->addHour());
                        }
                    })
                    ->required()
                    ->native(false)
                    ->displayFormat('l, d M Y')
                    ->minDate(now())
                    ->closeOnDateSelection()
                    ->weekStartsOnSunday()
                    ->live(),
                Select::make('start_time')
                    ->label('Pilih Jam Konsultasi')
                    ->options(function (Get $get) {
                        /* $timelist = [
                            '07:00:00' => '07:00',
                            '08:00:00' => '08:00',
                            '09:00:00' => '09:00',
                            '10:00:00' => '10:00',
                            '11:00:00' => '11:00',
                            '13:00:00' => '13:00',
                            '14:00:00' => '14:00',
                        ]; */ // old time

                        $timelist = [
                            '12:00:00' => '12:00-12:30',
                            '14:00:00' => '14:00-14:30',
                            '14:30:00' => '14:30-15:00',
                        ];
                        
                    
                        $startDate = $get('start_date');
                    
                        if ($startDate) {
                            $occupied = Event::where('start_date', $startDate)->pluck('start_time')->toArray() ?? [];
                    
                            $timelist = array_diff_key($timelist, array_flip($occupied));
                    
                            $currentKey = now()->format('H:i:s');
                            
                            $startDateCarbon = Carbon::parse($startDate);
                    
                            if ($startDateCarbon->isWeekend()) {
                                $timelist = [];
                            } elseif ($startDateCarbon->isToday()) {
                                $timelist = array_filter($timelist, fn($key) => $key >= $currentKey, ARRAY_FILTER_USE_KEY);
                            }
                        }
                    
                        return $timelist;
                    })
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $date = Carbon::parse($get('start_date'))->format('Y-m-d');
                        $time = $state;
                        if ($date) {
    
                            $set('starts_at', Carbon::parse($date . 'T' . $time));
                            $set('ends_at', Carbon::parse($date . 'T' . $time)->addHour());
                        }
                    })
                    ->required()
                    ->hidden(fn (Get $get) => $get('start_date') === null)
                    ->live(),
                TextInput::make('keterangan')
                    ->label('Keperluan Konsultasi untuk...')
                    ->required()
                    ->maxLength(255),
                Radio::make('izin_wk')
                    ->label(fn () => 'Apakah sudah izin ke Wali Kelas ' . auth()->user()->kelas . '?')
                    ->boolean(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.kelas')
                    ->label('Kelas')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Jam Konsultasi')
                    ->dateTime()
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('l, d M Y @ H:i'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\IconColumn::make('izin_wk')
                    ->label('Izin Wali Kelas')
                    ->boolean(),
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
