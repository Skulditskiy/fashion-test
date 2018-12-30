<?php

namespace Skulditskiy\FashionTest\Domain\Product;

interface ProductRepositoryInterface
{
    /**
     * @param SearchRequest $searchRequest
     * @return Product[]
     */
    public function searchBy(SearchRequest $searchRequest): array;
}