<?php

declare(strict_types=1);

namespace App\Services\Stocks;

class Rozetka extends SimpleStock
{
    public function getName(): string
    {
        return 'Rozetka';
    }

    public function getUrl(): string
    {
        return 'https://rozetka.com.ua';
    }

    protected function waitFor(): string
    {
        return '.product__status';
    }

    protected function availabilitySelector(): string
    {
        return '.product__status.product__status_color_green';
    }
}
