<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use BotMan\BotMan\BotMan;

class WishList
{
    public function handle(BotMan $bot)
    {
        $user = User::findByTelegramId($bot->getUser()->getId());

        $bot->typesAndWaits(1);
        $bot->reply(
            $user->productLinks()->notNotified()->pluck('url')->implode(PHP_EOL),
        );
    }
}
