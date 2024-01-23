<?php

use Carbon\Carbon;
use App\Models\Event;
use App\Mail\KonsulnotifEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $konsultasis = Event::whereDate('starts_at', Carbon::today())->get();
    if ($konsultasis) {
        foreach ($konsultasis as $key => $konsultasi) {
            Mail::to($konsultasi->users->email)
                ->send(new KonsulnotifEmail($konsultasi));

            return 'success';
        }
    }
    //return redirect('/app');
});
