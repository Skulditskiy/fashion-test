<?php

namespace Skulditskiy\FashionTest\Domain\Product;

use Skulditskiy\FashionTest\Domain\Money\Money;

/**
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="products")
 */
class Product implements \JsonSerializable
{
    const ALLOWED_ORDER_BY_FIELDS = ['title', 'brand', 'price', 'stock'];
    const ALLOWED_ORDER_BY_DIRECTION = ['ASC', 'DESC'];

    /**
     * @var string
     * @Doctrine\ORM\Mapping\Id
     * @Doctrine\ORM\Mapping\Column(name="id", type="string", length=36)
     */
    private $id;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(name="title", type="string", length=255)
     */
    private $title;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(name="brand", type="string", length=255)
     */
    private $brand;
    /**
     * @var Money
     * @Doctrine\ORM\Mapping\Embedded(class="\Skulditskiy\FashionTest\Domain\Money\Money", columnPrefix = "price_")
     */
    private $price;
    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @param string $id
     * @param string $title
     * @param string $brand
     * @param Money $price
     * @param int $stock
     */
    public function __construct(string $id, string $title, string $brand, Money $price, int $stock)
    {
        $this->id = $id;
        $this->title = $title;
        $this->brand = $brand;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'brand' => $this->brand,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }
}
