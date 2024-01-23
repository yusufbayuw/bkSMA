<?php

namespace App\Console;

use App\Mail\KonsulnotifEmail;
use App\Models\Event;
use App\Models\User;
use App\Models\Pilihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            // reset is_can_choose
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
        });

        $schedule->call(function () {
            //email konsultasi
            $konsultasis = Event::whereDate('starts_at', Carbon::today())->get();
            if ($konsultasis) {
                foreach ($konsultasis as $key => $konsultasi) {
                    Mail::to($konsultasi->users->email)->send(new KonsulnotifEmail($konsultasi));
                }
            }
        });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
