<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

class Foxtrot extends Stock
{
    public function getName(): string
    {
        return 'Foxtrot';
    }

    public function getUrl(): string
    {
        return 'https://www.foxtrot.com.ua';
    }

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            try {
                $browser->waitFor('.product-box__main-buy__button', 10);
            } catch (\Exception $e) {
                $this->result = false;

                return;
            }

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            $buyButton = $crawler->filter('.product-box__main-buy__button');

            if ($buyButton->count() > 0
                && !Str::of($buyButton->first()->attr('class'))->contains('product-not-avail-button')
            ) {
                $this->result = true;
            }
        };
    }
}
