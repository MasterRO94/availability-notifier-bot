<?php

declare(strict_types=1);

namespace App\Services\Stocks;

class RozetkaTest extends Rozetka
{
    public function getUrl(): string
    {
        return 'https://rozetka.com.ua/playstation_9391401/p231481033/';
    }
}
