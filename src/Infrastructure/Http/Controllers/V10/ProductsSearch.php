<?php

namespace Skulditskiy\FashionTest\Infrastructure\Controllers\V10;

use Psr\Http\Message\ServerRequestInterface;
use Skulditskiy\FashionTest\Domain\Product\ProductRepositoryInterface;
use Skulditskiy\FashionTest\Domain\Product\SearchRequestFactory;
use Slim\Http\Response;
use Zend\InputFilter\InputFilterInterface;

class ProductsSearch
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var SearchRequestFactory
     */
    private $searchRequestFactory;
    /**
     * @var InputFilterInterface
     */
    private $inputFilter;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param SearchRequestFactory $searchRequestFactory
     * @param InputFilterInterface $inputFilter
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchRequestFactory $searchRequestFactory,
        InputFilterInterface $inputFilter
    ) {
        $this->productRepository = $productRepository;
        $this->searchRequestFactory = $searchRequestFactory;
        $this->inputFilter = $inputFilter;
    }

    public function execute(ServerRequestInterface $request, Response $response)
    {
        $this->inputFilter->setData($request->getQueryParams());

        if ($this->inputFilter->isValid()) {
            $searchRequest = $this->searchRequestFactory->create($this->inputFilter->getValues());
            $response = $response->withJson(
                $this->productRepository->searchBy($searchRequest),
                200,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
        } else {
            $response = $response->withJson(
                [$this->inputFilter->getMessages()],
                400,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );
        }
        return $response;
    }
}
