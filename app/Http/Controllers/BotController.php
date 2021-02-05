<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\Check;
use App\Commands\RegisterLink;
use App\Commands\RegisterUser;
use App\Commands\WishList;
use BotMan\BotMan\BotMan;
use Throwable;

/**
 * Class BotController
 *
 * @package App\Http\Controllers
 */
class BotController extends Controller
{
    protected $commands = [
        '/start'     => RegisterUser::class,
        'http.*'     => RegisterLink::class,
        '/wish_list' => WishList::class,
        '/check'     => Check::class,
    ];

    public function __invoke(string $webhookSecret, BotMan $botman)
    {
        if (config('webhooks.telegram.secret') !== $webhookSecret) {
            return response()->json(['error' => 'Permission denied.'], 403);
        }

        try {
            $this->registerCommands($botman);

            $botman->fallback(function (BotMan $bot) {
                $bot->typesAndWaits(1);
                $bot->reply(__('Команда не распознана.'));
            });

            $botman->listen();
        } catch (Throwable $exception) {
            report($exception);
        }

        return response()->json(['ok' => 'OK']);
    }

    protected function registerCommands(BotMan $botman)
    {
        foreach ($this->commands as $command => $handler) {
            $botman->hears($command, $handler . '@handle');
        }
    }
}
