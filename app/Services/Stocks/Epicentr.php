<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Exception;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

class Epicentr extends Stock
{
    public function getName(): string
    {
        return 'Foxtrot';
    }

    public function getUrl(): string
    {
        return 'https://epicentrk.ua';
    }

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            try {
                $browser->waitFor('.p-block--info', 10);
            } catch (Exception $e) {
                return;
            }

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.p-buy__btn')->count() > 0) {
                $this->result = true;
            }
        };
    }
}
