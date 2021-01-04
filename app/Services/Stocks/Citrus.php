<?php

declare(strict_types=1);

namespace App\Services\Stocks;

class Citrus extends SimpleStock
{
    public function getName(): string
    {
        return 'Citrus';
    }

    public function getUrl(): string
    {
        return 'https://www.citrus.ua';
    }

    protected function waitFor(): string
    {
        return '.buy-block';
    }

    protected function availabilitySelector(): string
    {
        return '.buy-block__base';
    }
}
