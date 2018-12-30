<?php

namespace Skulditskiy\FashionTest\Domain\Money;

use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /**
     * @test
     */
    public function jsonSerialize_test()
    {
        // prepare
        $amount = 159.49 * 1000000;
        $currency = 'USD';

        $classUnderTest = new Money($amount, $currency);

        $expectedResult = [
            'amount' => $amount,
            'currency' => $currency,
        ];

        // test
        $result = $classUnderTest->jsonSerialize();

        // verify
        $this->assertEquals($expectedResult, $result);
    }
}
