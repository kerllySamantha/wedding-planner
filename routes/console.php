<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('recordatorio:boda-proxima')->dailyAt('09:00');
Schedule::command('recordatorio:presupuestos-pendientes')->dailyAt('10:00');
Schedule::command('recordatorio:tareas-pendientes')->dailyAt('11:00');