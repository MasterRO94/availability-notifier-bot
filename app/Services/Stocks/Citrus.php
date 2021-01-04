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
        return 'https://www.citrus.ua';
    }

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            try {
                $browser->waitFor('.buy-block', 10);
            } catch (\Exception $e) {
                $this->result = false;

                return;
            }

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.buy-block__base')->count() > 0) {
                $this->result = true;
            }
        };
    }
}
