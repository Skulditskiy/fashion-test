<?php

namespace Skulditskiy\FashionTest\Application\RequestFilters;

use PHPUnit\Framework\TestCase;

class ProductsSearchRequestFilterTest extends TestCase
{
    /**
     * @test
     * @dataProvider getData
     */
    public function filter_test($inputData, $expectedFilteredData)
    {
        // prepare
        $classUnderTest = new ProductsSearchRequestFilter();

        // test
        $classUnderTest->setData($inputData);
        $classUnderTest->isValid();
        $result = $classUnderTest->getValues();

        // verify
        $this->assertEquals($expectedFilteredData, $result);
    }

    public function getData()
    {
        return [
            [
                [],
                [
                    'brand' => '',
                    'title' => '',
                    'orderBy' => 'price',
                    'orderDirection' => 'ASC',
                    'limit' => 10,
                    'offset' => 0,
                ]
            ],
            [
                [
                    'brand' => 'some brand',
                    'title' => 'some title',
                    'orderBy' => 'some order by field',
                    'orderDirection' => 'DESC',
                    'limit' => 123,
                    'offset' => 50,
                ],
                [
                    'brand' => 'some brand',
                    'title' => 'some title',
                    'orderBy' => 'some order by field',
                    'orderDirection' => 'DESC',
                    'limit' => 123,
                    'offset' => 50,
                ]
            ],
            [
                [
                    'limit' => 'some invalid value',
                    'offset' => 'other invalid value',
                ],
                [
                    'brand' => '',
                    'title' => '',
                    'orderBy' => 'price',
                    'orderDirection' => 'ASC',
                    'limit' => 10,
                    'offset' => 0,
                ]
            ]
        ];
    }
}
