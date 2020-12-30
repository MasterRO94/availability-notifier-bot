<?php

declare(strict_types=1);

namespace App\Foundation;

use App\Models\User;
use Illuminate\Http\Request;
use BotMan\Drivers\Telegram\TelegramDriver;

class Helper
{
    public static function say($message, $recipients)
    {
        app('botman')->say(
            $message,
            $recipients,
            TelegramDriver::class,
        );
    }

    public static function getUserFromRequest(Request $request = null)
    {
        $request ??= request();

        $id = $request->input('message.from.id') ?? $request->input('callback_query.from.id');

        return $id ? User::findByTelegramId($id) : null;
    }
}
