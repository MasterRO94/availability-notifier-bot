<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Closure;
use DuskCrawler\Dusk;

abstract class Stock
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

    public function check()
    {
        $dusk = new Dusk('search-packagist');

        $dusk->headless()->disableGpu()->noSandbox();
        $dusk->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');

        $dusk->start();

        $dusk->browse($this->browseCallback());

        $dusk->stop();

        return $this->result;
    }

    abstract protected function browseCallback(): Closure;
}
