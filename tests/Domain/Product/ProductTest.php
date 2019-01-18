<?php

namespace Skulditskiy\FashionTest\Domain\Product;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Skulditskiy\FashionTest\Domain\Money\Money;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function construct_test()
    {
        // prepare
        /** @var Money|MockObject $priceMock */
        $priceMock = $this->createMock(Money::class);

        $classUnderTest = new Product('some title', 'some brand', $priceMock, 123);

        // test

        // verify
        $this->assertInstanceOf(Product::class, $classUnderTest);
    }

    /**
     * @test
     */
    public function jsonSerialize_test()
    {
        // prepare
        $id = '';
        $title = 'some title';
        $brand = 'some brand';
        $stock = 123;

        /** @var Money|MockObject $priceMock */
        $priceMock = $this->createMock(Money::class);

        $classUnderTest = new Product($title, $brand, $priceMock, $stock);

        $expectedResult = [
            'id' => '',
            'title' => $title,
            'brand' => $brand,
            'price' => $priceMock,
            'stock' => $stock,
        ];

        // test
        $result = $classUnderTest->jsonSerialize();

        // verify
        $this->assertEquals($expectedResult, $result);
    }
}
