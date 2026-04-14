<?php

use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('clear-orders', function () {
    OrderController::clearOrders();
})->purpose('Check and clear orders older than 15min');

//scheduling di un comando artisan (vedi sopra)
Schedule::command('clear-orders')->everyMinute();
//scheduling di una funzione
// Schedule::call(function () {
    
// })->hourly();