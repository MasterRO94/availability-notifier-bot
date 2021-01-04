<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class StocksCollection extends Collection
{
    public static function create()
    {
        return static::make([
            Rozetka::make(),
            Citrus::make(),
            Comfy::make(),
            Foxtrot::make(),
            Epicentr::make(),
        ]);
    }

    public function findByUrl(string $url): ?StockContract
    {
        return $this->first(
            fn(StockContract $stock) => Str::of($url)->startsWith($stock->getUrl())
        );
    }
}
