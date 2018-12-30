<?php

namespace Skulditskiy\FashionTest\Infrastructure\Controllers\V10;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Skulditskiy\FashionTest\Domain\Product\ProductRepositoryInterface;
use Skulditskiy\FashionTest\Domain\Product\SearchRequest;
use Skulditskiy\FashionTest\Domain\Product\SearchRequestFactory;
use Slim\Http\Response;
use Zend\InputFilter\InputFilterInterface;

class ProductsSearchTest extends TestCase
{
    /**
     * @test
     */
    public function execute_withInvalidInput_test()
    {
        // prepare
        /** @var ProductRepositoryInterface|MockObject $productRepositoryMock */
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);

        /** @var SearchRequestFactory|MockObject $searchRequestFactoryMock */
        $searchRequestFactoryMock = $this->createMock(SearchRequestFactory::class);

        /** @var InputFilterInterface|MockObject $inputFilterMock */
        $inputFilterMock = $this->createMock(InputFilterInterface::class);
        $inputFilterMock->expects($this->once())
            ->method('isValid')
            ->willReturn(false);
        $inputFilterMock->expects($this->once())
            ->method('getMessages')
            ->willReturn(['some errors', 'description']);

        /** @var ServerRequestInterface|MockObject $requestMock */
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['some' => 'query', 'parameters' => 'values']);

        /** @var Response|MockObject $responseMock */
        $responseMock = $this->createMock(Response::class);
        $responseMock->expects($this->once())
            ->method('withJson');

        $classUnderTest = new ProductsSearch($productRepositoryMock, $searchRequestFactoryMock, $inputFilterMock);

        // test
        $classUnderTest->execute($requestMock, $responseMock);

        // verified by expected count of calling methods in input filter and in response
    }

    /**
     * @test
     */
    public function execute_withValidInput_test()
    {
        // prepare
        $expectedJsonData = ['some', 'search', 'result'];

        /** @var SearchRequest|MockObject $searchRequestMock */
        $searchRequestMock = $this->createMock(SearchRequest::class);

        /** @var ProductRepositoryInterface|MockObject $productRepositoryMock */
        $productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $productRepositoryMock->expects($this->once())
            ->method('searchBy')
            ->with($searchRequestMock)
            ->willReturn($expectedJsonData);

        /** @var SearchRequestFactory|MockObject $searchRequestFactoryMock */
        $searchRequestFactoryMock = $this->createMock(SearchRequestFactory::class);
        $searchRequestFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($searchRequestMock);

        /** @var InputFilterInterface|MockObject $inputFilterMock */
        $inputFilterMock = $this->createMock(InputFilterInterface::class);
        $inputFilterMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);
        $inputFilterMock->expects($this->never())
            ->method('getMessages')
            ->willReturn(['some errors', 'description']);
        $inputFilterMock->expects($this->once())
            ->method('getValues')
            ->willReturn(['some filtered', 'request data']);

        /** @var ServerRequestInterface|MockObject $requestMock */
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $requestMock->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['some' => 'query', 'parameters' => 'values']);

        /** @var Response|MockObject $responseMock */
        $responseMock = $this->createMock(Response::class);
        $responseMock->expects($this->once())
            ->method('withJson')
            ->with($expectedJsonData, 200, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $classUnderTest = new ProductsSearch($productRepositoryMock, $searchRequestFactoryMock, $inputFilterMock);

        // test
        $classUnderTest->execute($requestMock, $responseMock);

        // verified by exact returned json data in response
    }
}
