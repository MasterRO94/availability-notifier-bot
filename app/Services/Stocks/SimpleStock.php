<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Exception;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

abstract class SimpleStock extends Stock
{
    abstract protected function waitFor(): string;

    abstract protected function availabilitySelector(): string;

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            try {
                $browser->waitFor($this->waitFor(), 10);
            } catch (Exception $e) {
                report($e);

                return;
            }

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            $this->checkAvailability($crawler);
        };
    }

    protected function checkAvailability(Crawler $crawler): void
    {
        if ($crawler->filter($this->availabilitySelector())->count() > 0) {
            $this->result = true;
        }
    }
}
