<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

class Citrus extends Stock
{
    public function getName(): string
    {
        return 'Citrus';
    }

    public function getUrl(): string
    {
        return 'https://www.citrus.ua/igrovye-pristavki/igrovaya-konsol-sony-playstation-5-663700.html';
    }

    protected function browseCallback(): Closure
    {
        return function (Browser $browser) {
            $browser->visit($this->getUrl());

            $browser->waitFor('.buy-block', 5);

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.buy-block__base')->count() > 0) {
                $this->result = true;
            }
        };
    }
}
