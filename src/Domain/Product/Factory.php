<?php

namespace Skulditskiy\FashionTest\Domain\Product;

use Skulditskiy\FashionTest\Domain\Money\Money;

class Factory
{
    public function create(string $title, string $brand, float $amount, string $currency, int $stock)
    {
        return new Product($title, $brand, new Money($amount, $currency), $stock);
    }
}
