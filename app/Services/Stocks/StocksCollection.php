<?php

declare(strict_types=1);

namespace App\Services\Stocks;

use Illuminate\Support\Collection;

class StocksCollection extends Collection
{
    public static function create()
    {
        return static::make([
            Rozetka::make(),
            Citrus::make(),
            RozetkaTest::make(),
            CitrusTest::make(),
        ]);
    }
}
