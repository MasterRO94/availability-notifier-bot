<?php

namespace App\Jobs;

use App\Foundation\Helper;
use App\Models\ProductLink;
use App\Models\User;
use App\Services\Stocks\StockChecker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckAvailability implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $linkUsers = [];

    protected array $usersToNotify = [];

    public function handle()
    {
        $this->prepareLinkUsers();
        $this->checkStocks();
        $this->notifyUsers();
    }

    protected function prepareLinkUsers()
    {
        /** @var User[] $users */
        User::chunk(100, function (Collection $users) {
            foreach ($users as $user) {
                /** @var ProductLink $productLink */
                foreach ($user->productLinks()->notNotified()->get() as $productLink) {
                    if (!isset($this->linkUsers[$productLink->url])) {
                        $this->linkUsers[$productLink->url] = [];
                    }

                    if (!in_array($user->telegram_user_id, $this->linkUsers[$productLink->url])) {
                        $this->linkUsers[$productLink->url][] = $user->telegram_user_id;
                    }
                }
            }
        });
    }

    protected function checkStocks()
    {
        foreach ($this->linkUsers as $url => $telegramUserIds) {
            if (StockChecker::create($url)->check()) {
                $this->usersToNotify[$url] = $telegramUserIds;
            }
        }
    }

    protected function notifyUsers()
    {
        foreach ($this->usersToNotify as $url => $telegramUserIds) {
            Helper::say(
                __("Продукт доступен к заказу :url", ['url' => $url]),
                $telegramUserIds
            );
        }

        ProductLink::whereIn('url', array_keys($this->usersToNotify))->update([
            'notified_at' => now(),
        ]);
    }
}
