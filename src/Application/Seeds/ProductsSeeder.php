<?php

use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;
use Skulditskiy\FashionTest\Domain\Money\Money;

class ProductsSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'id' => Uuid::uuid4(),
                'title' => 'some title 1',
                'brand' => 'some brand 1',
                'price_amount' => 14.99 * Money::MULTIPLIER,
                'price_currency' => 'EUR',
                'stock' => 123,
            ],
            [
                'id' => Uuid::uuid4(),
                'title' => 'some title 2',
                'brand' => 'some brand 2',
                'price_amount' => 6.49 * Money::MULTIPLIER,
                'price_currency' => 'EUR',
                'stock' => 25,
            ],
        ];

        $posts = $this->table('products');
        $posts->insert($data)
            ->save();
    }
}
