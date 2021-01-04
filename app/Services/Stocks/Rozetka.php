<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

class Rozetka extends Stock
{
    public function getName(): string
    {
        return 'Rozetka';
    }

    public function getUrl(): string
    {
        return 'https://rozetka.com.ua';
    }

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            $browser->waitFor('.product__status', 5);

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.product__status.product__status_color_green')->count() > 0) {
                $this->result = true;
            }
        };
    }
}
