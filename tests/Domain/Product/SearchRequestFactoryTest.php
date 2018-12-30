<?php

namespace Skulditskiy\FashionTest\Domain\Product;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Skulditskiy\FashionTest\Domain\Money\Money;

class SearchRequestFactoryTest extends TestCase
{
    private $title = 'some title';
    private $brand = 'some brand';
    private $orderBy = 'some field to order by';
    private $orderDirection = 'asc, desc or rand';
    private $limit = 15;
    private $offset = 120;

    /**
     * @test
     */
    public function create_test()
    {
        // prepare
        $expectedResult = new SearchRequest(
            $this->title,
            $this->brand,
            $this->orderBy,
            $this->orderDirection,
            $this->limit,
            $this->offset
        );
        $parameters = [
            'title' => $this->title,
            'brand' => $this->brand,
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->orderDirection,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];

        $classUnderTest = new SearchRequestFactory();

        // test
        $result = $classUnderTest->create($parameters);

        // verify
        $this->assertEquals($expectedResult, $result);
    }


}
