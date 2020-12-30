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
        return 'https://rozetka.com.ua/playstation_5/p223588825/';
    }

    protected function browseCallback(): Closure
    {
        return function (Browser $browser) {
            $browser->visit($this->getUrl());

            $browser->waitFor('.product__status', 5);

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.product__status.product__status_color_green')->count() > 0) {
                $this->result = true;
            }
        };
    }
}
