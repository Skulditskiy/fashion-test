<?php

namespace Skulditskiy\FashionTest\Domain\Money;

/** @Doctrine\ORM\Mapping\Embeddable */
class Money implements \JsonSerializable
{
    const MULTIPLIER = 1000000;

    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(name="amount", type="integer")
     */
    private $amount;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @param int $amount
     * @param string $currency
     */
    public function __construct(int $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function jsonSerialize()
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
