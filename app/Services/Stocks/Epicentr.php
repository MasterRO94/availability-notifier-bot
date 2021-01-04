<?php

declare(strict_types=1);

namespace App\Services\Stocks;

class Epicentr extends SimpleStock
{
    public function getName(): string
    {
        return 'Foxtrot';
    }

    public function getUrl(): string
    {
        return 'https://epicentrk.ua';
    }

    protected function waitFor(): string
    {
        return '.p-block--info';
    }

    protected function availabilitySelector(): string
    {
        return '.p-buy__btn';
    }
}
