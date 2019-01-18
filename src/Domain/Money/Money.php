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
     * @param float $amount
     * @param string $currency
     */
    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount * self::MULTIPLIER;
        $this->currency = $currency;
    }

    public function jsonSerialize()
    {
        return [
            'amount' => $this->amount / self::MULTIPLIER,
            'currency' => $this->currency,
        ];
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }


}
