<?php

declare(strict_types=1);

namespace App\Commands;

use App\Models\User;
use BotMan\BotMan\BotMan;
use Validator;

class RegisterLink
{
    public function handle(BotMan $bot)
    {
        $validator = Validator::make([
            'url' => $bot->getMessage()->getText(),
        ], [
            'url' => 'url',
        ]);

        $bot->typesAndWaits(1);

        if ($validator->fails()) {
            $bot->reply(__('Невалидная ссылка.'));

            return;
        }

        $user = User::findByTelegramId($bot->getUser()->getId());

        $productLink = $user->productLinks()->updateOrCreate($validator->validated(), [
            'notified_at' => null,
        ]);

        $reply = $productLink->wasRecentlyCreated || !count($productLink->getDirty())
            ? __('Товар добавлен в список ожидания.')
            : __('Товар уже добавлен в список ожидания.');

        $bot->reply(__($reply));
    }
}
