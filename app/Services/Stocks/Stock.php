<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use DuskCrawler\Dusk;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

abstract class Stock implements StockContract
{
    protected bool $result = false;

    protected Dusk $dusk;

    public static function make(): Stock
    {
        return app(static::class);
    }

    public function setDusk(Dusk $dusk): self
    {
        $this->dusk = $dusk;

        return $this;
    }

    public function check(string $url): bool
    {
        if (!$this->dusk) {
            throw new RuntimeException('Dusk must be set before method call');
        }

        if (!Str::of($url)->startsWith($this->getUrl())) {
            throw new InvalidArgumentException("Specified URL ({$url}) is not valid for stock {$this->getName()}");
        }

        $this->dusk->browse($this->browseCallback($url));

        return $this->result;
    }

    abstract protected function browseCallback(string $url): Closure;
}
