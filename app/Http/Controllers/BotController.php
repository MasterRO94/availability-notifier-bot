<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use BotMan\BotMan\BotMan;
use Throwable;

/**
 * Class BotController
 *
 * @package App\Http\Controllers
 */
class BotController extends Controller
{
    public function __invoke(string $webhookSecret, BotMan $botman)
    {
        if (config('webhooks.telegram.secret') !== $webhookSecret) {
            return response()->json(['error' => 'Permission denied.'], 403);
        }

        try {
            $botman->hears('/start', function (BotMan $bot) {
                $user = User::updateOrCreate([
                    'telegram_user_id' => $bot->getUser()->getId(),
                ], [
                    'username'   => $bot->getUser()->getUsername(),
                    'first_name' => $bot->getUser()->getFirstName(),
                    'last_name'  => $bot->getUser()->getLastName(),
                ]);

                if ($user->exists) {
                    $bot->reply('Уже зарегистрирован');
                } else {
                    $bot->reply('Зарегистрирован. Жди уведомления :)');
                }
            });

            $botman->fallback(function (BotMan $bot) {
                $bot->typesAndWaits(1);
                $bot->reply('Команда не распознана');
            });

            $botman->listen();
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json(['ok' => 'OK']);
    }
}
