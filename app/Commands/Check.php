<?php

declare(strict_types=1);

namespace App\Commands;

use App\Jobs\CheckAvailability as CheckAvailabilityJob;
use BotMan\BotMan\BotMan;

class Check
{
    public function handle(BotMan $bot)
    {
        $bot->typesAndWaits(1);
        $bot->reply('Проверяю');

        CheckAvailabilityJob::dispatch();
    }
}
