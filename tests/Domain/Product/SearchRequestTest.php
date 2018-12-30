<?php

namespace Skulditskiy\FashionTest\Domain\Product;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Skulditskiy\FashionTest\Domain\Money\Money;

class SearchRequestTest extends TestCase
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
    public function getTitle_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->title;

        // test
        $result = $classUnderTest->getTitle();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getBrand_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->brand;

        // test
        $result = $classUnderTest->getBrand();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getOrderBy_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->orderBy;

        // test
        $result = $classUnderTest->getOrderBy();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getOrderDirection_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->orderDirection;

        // test
        $result = $classUnderTest->getOrderDirection();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getLimit_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->limit;

        // test
        $result = $classUnderTest->getLimit();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function getOffset_test()
    {
        // prepare
        $classUnderTest = $this->getSampleSearchRequest();
        $expectedResult = $this->offset;

        // test
        $result = $classUnderTest->getOffset();

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return SearchRequest
     */
    private function getSampleSearchRequest(): SearchRequest
    {
        return new SearchRequest(
            $this->title,
            $this->brand,
            $this->orderBy,
            $this->orderDirection,
            $this->limit,
            $this->offset
        );
    }
}
