<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use DuskCrawler\Dusk;
use InvalidArgumentException;

class StockChecker
{
    protected Dusk $dusk;

    public function __construct()
    {
        $this->dusk = new Dusk(static::class);

        $this->dusk->headless()->disableGpu()->noSandbox();
        $this->dusk->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

        $this->dusk->start();
}
    public function findStock(string $url): ?Stock
    {
        return StocksCollection::create()->findByUrl($url);
    }

    public function check(string $url): bool
    {
        $stock = $this->findStock($url);

        if (!$stock) {
            throw new InvalidArgumentException("Specified URL ({$url}) is not supported by available stocks.");
        }

        return $stock->setDusk($this->dusk)->check($url);
    }

    public function __destruct()
    {
        $this->dusk->stop();
    }
}
