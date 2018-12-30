<?php

namespace Skulditskiy\FashionTest\Domain\Product;

class SearchRequest
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $brand;
    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $orderDirection;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;

    /**
     * @param string $title
     * @param string $brand
     * @param string $orderBy
     * @param string $orderDirection
     * @param int $limit
     * @param int $offset
     */
    public function __construct(
        string $title,
        string $brand,
        string $orderBy,
        string $orderDirection,
        int $limit,
        int $offset
    ) {
        $this->title = $title;
        $this->brand = $brand;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @return string
     */
    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

}
