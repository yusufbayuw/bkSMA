<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Event;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\EventResource;
use Filament\Forms\Components\DatePicker;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class XalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Event::class;

    public function getFormSchema(): array
    {
        return [
            Hidden::make('user_id')->default(auth()->user()->id),
            TextInput::make('nama')
                ->default(auth()->user()->name)
                ->readOnly()
                ->maxLength(255),
            Hidden::make('starts_at'),
            Hidden::make('ends_at'),//->live()->afterStateUpdated(fn ($state) => dd($state))->closeOnDateSelection(),
            DatePicker::make('start_date')
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
            Select::make('start_time')
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
                ->title($event->nama)
                ->start($event->starts_at)
                ->end($event->ends_at)
                ->url(
                    url: EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    shouldOpenUrlInNewTab: true
                )
        )
        ->toArray();
    }

}
