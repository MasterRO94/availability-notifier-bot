<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use InvalidArgumentException;

class StockChecker
{
    protected string $url;

    protected ?StockContract $stock;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->stock = $this->findStock();

        if (!$this->stock) {
            throw new InvalidArgumentException("Specified URL ({$url}) is not supported by available stocks.");
        }
    }

    public static function create(string $url)
    {
        return new static($url);
    }

    public function findStock(): ?StockContract
    {
        return StocksCollection::create()->findByUrl($this->url);
    }

    public function check(): bool
    {
        return $this->stock->check($this->url);
    }
}
