<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Event;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Actions\ViewAction;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class XalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    public function getFormSchema(): array
    {
        return [
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
                ->minDate(now()->startOfDay())
                ->closeOnDateSelection()
                ->weekStartsOnSunday()
                ->live(),
            Select::make('start_time')
                ->label('Pilih Jam Konsultasi')
                ->options(function (Get $get) {
<<<<<<< HEAD
                    /* $timelist = [
                        '08:00:00' => '08:00 - 09:00',
                        '09:00:00' => '09:00 - 10:00',
                        '10:00:00' => '10:00 - 11:00',
                        '13:00:00' => '13:00 - 14:00',
                    ]; */

                    $timelist = [
                        '12:00:00' => '12:00-12:30',
                        '14:00:00' => '14:00-14:30',
                        '14:30:00' => '14:30-15:00',
=======
                    $timelist = [
                        '12:00:00' => '12:00 - 12.30',
                        '14:00:00' => '14:00 - 14:30',
                        '14:30:00' => '14:30 - 15:00',
>>>>>>> 94316dbab7cac24705dbd1c8b565243119ae8ce0
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
            TextInput::make('keterangan')->label('Keperluan Konsultasi untuk...')->required()->maxLength(255),
<<<<<<< HEAD
            Checkbox::make('izin_wk')
                ->label('Saya sudah izin Wali Kelas')
                ->accepted()
                ->validationMessages(['accepted' => 'Ceklist bahwa Anda sudah izin ke Wali Kelas']),
            /* Radio::make('izin_wk')
                    ->label(fn () => 'Apakah sudah izin ke Wali Kelas ' . auth()->user()->kelas . '?')
                    ->boolean(), */
=======
            Checkbox::make('izin_mk')
                ->label('Saya sudah izin Wali Kelas '.(auth()->user()->kelas ?? null))
                ->inline()
                ->accepted()
                ->validationMessages([
                    "accepted" => "Anda harus izin wali kelas terlebih dahulu 🤨"
                ]),
>>>>>>> 94316dbab7cac24705dbd1c8b565243119ae8ce0
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return Event::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Event $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->users->name)
                    ->start($event->starts_at)
                    ->end($event->ends_at)
            )
            ->toArray();
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus-circle')->label('Booking Konsultasi')->modalHeading('Booking Jadwal'),
        ];
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make()->hidden(!auth()->user()->hasRole(['super_admin', 'guru_bk'])),
            DeleteAction::make()->hidden(!auth()->user()->hasRole(['super_admin', 'guru_bk'])),
        ];
    }

    protected function viewAction(): Action
    {
        return ViewAction::make()->hidden(!auth()->user()->hasRole(['super_admin', 'guru_bk']));
    }
}
