<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;

class Comfy extends Stock
{
    public function getName(): string
    {
        return 'Comfy';
    }

    public function getUrl(): string
    {
        return 'https://comfy.ua';
    }

    protected function browseCallback(string $url): Closure
    {
        return function (Browser $browser) use ($url) {
            $browser->visit($url);

            try {
                $browser->waitFor('.buy', 10);
            } catch (\Exception $e) {
                $this->result = false;

                return;
            }

            /** @var Crawler $crawler */
            $crawler = $browser->crawler();

            if ($crawler->filter('.buy')->count() > 0) {
                $this->result = true;
            }
        };
    }
}