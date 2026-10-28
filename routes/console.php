<?php

use Illuminate\Support\Facades\Schedule;

// ซิงค์ทุก 30 นาที เฉพาะวันจันทร์ - ศุกร์ ระหว่างเวลา 08:00 ถึง 16:30 น.
Schedule::command('kintone:sync-all')
    ->everyThirtyMinutes()
    ->weekdays()
    ->between('08:00', '16:30')
    ->withoutOverlapping(10);