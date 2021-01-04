<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use DuskCrawler\Dusk;
use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class Stock implements StockContract
{
    protected Dusk $dusk;

    protected bool $result = false;

    public function __construct()
    {
        $this->dusk = new Dusk($this->getName());
    }

    public static function make(): Stock
    {
        return app(static::class);
    }

    public function check(string $url): bool
    {
        if (!Str::of($url)->startsWith($this->getUrl())) {
            throw new InvalidArgumentException("Specified URL ({$url}) is not valid for stock {$this->getName()}");
        }

        $this->dusk->headless()->disableGpu()->noSandbox();
        $this->dusk->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

        $this->dusk->start();
        $this->dusk->browse($this->browseCallback($url));
        $this->dusk->stop();

        return $this->result;
    }

    abstract protected function browseCallback(string $url): Closure;
}
