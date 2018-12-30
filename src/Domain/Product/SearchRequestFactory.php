<?php

namespace Skulditskiy\FashionTest\Domain\Product;

class SearchRequestFactory
{
    /**
     * @param array $parameters
     * @return SearchRequest
     */
    public function create(array $parameters): SearchRequest
    {
        return new SearchRequest(
            $parameters['title'],
            $parameters['brand'],
            $parameters['orderBy'],
            $parameters['orderDirection'],
            $parameters['limit'],
            $parameters['offset']
        );
    }
}
