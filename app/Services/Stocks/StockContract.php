<?php

declare(strict_types=1);

namespace App\Services\Stocks;

interface StockContract
{
    public function getName(): string;

    public function getUrl(): string;

    public function check(string $url): bool;
}
