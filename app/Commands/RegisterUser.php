<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use BotMan\BotMan\BotMan;

class RegisterUser
{
    public function handle(BotMan $bot)
    {
        $user = User::updateOrCreate([
            'telegram_user_id' => $bot->getUser()->getId(),
        ], [
            'username'   => $bot->getUser()->getUsername(),
            'first_name' => $bot->getUser()->getFirstName(),
            'last_name'  => $bot->getUser()->getLastName(),
        ]);

        $bot->typesAndWaits(1);
        $bot->reply(__('Отправь мне ссылку на товар и я сообщу как только он станет доступен.'));
    }
}
