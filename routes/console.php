<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('tokens:recharge')
        ->monthlyOn(1, '00:00') 
        ->name('monthly-tokens-recharge')
        ->withoutOverlapping();


Schedule::command('tokens:recharge')->everyMinute();
