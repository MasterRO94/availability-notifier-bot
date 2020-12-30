<?php

namespace App\Jobs;

use App\Foundation\Helper;
use App\Models\User;
use App\Services\Stocks\Stock;
use App\Services\Stocks\StocksCollection;
use BotMan\BotMan\BotMan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CheckAvailability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?BotMan $botman;

    public function handle(BotMan $botMan)
    {
        $this->botman = $botMan;

        $this->check();
    }

    protected function check()
    {
        $stocks = $this->getAvailableStocks();

        if ($stocks->isEmpty()) {
            return;
        }

        $this->notifyUsers($stocks);
    }

    protected function getAvailableStocks(): StocksCollection
    {
        return StocksCollection::create()->filter(fn(Stock $stock) => $stock->check());
    }

    protected function notifyUsers(StocksCollection $stocks)
    {

        $stocks->each(function (Stock $stock) {
            foreach (User::pluck('telegram_user_id') as $telegramUserId) {
                $cacheKey = md5($stock->getName() . $telegramUserId);

                if (!cache()->has($cacheKey)) {
                    Helper::say(
                        "Найдена плойка на {$stock->getName()}: {$stock->getUrl()}",
                        $telegramUserId
                    );

                    cache()->put($cacheKey, "{$stock->getName()} - {$telegramUserId}", Carbon::now()->addHours(3));
                }
            }
        });
    }
}
