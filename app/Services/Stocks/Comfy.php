<?php

declare(strict_types=1);

namespace App\Services\Stocks;

class Comfy extends SimpleStock
{
    public function getName(): string
    {
        return 'Comfy';
    }

    public function getUrl(): string
    {
        return 'https://comfy.ua';
    }

    protected function waitFor(): string
    {
        return '.product-card-header';
    }

    protected function availabilitySelector(): string
    {
        return '.buy';
    }
}
