<?php

namespace Skulditskiy\FashionTest\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Skulditskiy\FashionTest\Domain\Product\SearchRequest;

class ProductRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function searchBy_withAllPossibleValidParameters_test()
    {
        // prepare
        $expectedResult = ['result 1', 'result 2'];

        /** @var Query|MockObject $queryMock */
        $queryMock = $this->createMock(AbstractQuery::class);

        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        $queryBuilderMock->expects($this->at(0))
            ->method('select')
            ->willReturnSelf();
        $queryBuilderMock->expects($this->at(1))
            ->method('from');

        $queryBuilderMock->expects($this->at(2))
            ->method('andWhere');
        $queryBuilderMock->expects($this->at(3))
            ->method('setParameter')
            ->with('title', '%some title to search%');

        $queryBuilderMock->expects($this->at(4))
            ->method('andWhere');
        $queryBuilderMock->expects($this->at(5))
            ->method('setParameter')
            ->with('brand', '%some brand to search%');

        $queryBuilderMock->expects($this->at(6))
            ->method('addOrderBy')
            ->with('p.price.amount', 'ASC');

        $queryBuilderMock->expects($this->at(7))
            ->method('setMaxResults')
            ->with(12);
        $queryBuilderMock->expects($this->at(8))
            ->method('setFirstResult')
            ->with(100);

        $queryBuilderMock->expects($this->at(9))
            ->method('getQuery')
            ->willReturn($queryMock);

        $queryMock->method('getResult')->willReturn($expectedResult);

        /** @var EntityManagerInterface|MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $entityManagerMock->method('createQueryBuilder')
            ->willReturn($queryBuilderMock);

        /** @var SearchRequest|MockObject $searchRequestMock */
        $searchRequestMock = $this->createMock(SearchRequest::class);
        $searchRequestMock->method('getTitle')->willReturn('some title to search');
        $searchRequestMock->method('getBrand')->willReturn('some brand to search');
        $searchRequestMock->method('getOrderDirection')->willReturn('ASC');
        $searchRequestMock->method('getOrderBy')->willReturn('price');
        $searchRequestMock->method('getLimit')->willReturn(12);
        $searchRequestMock->method('getOffset')->willReturn(100);

        $classUnderTest = new ProductRepository($entityManagerMock);

        // test
        $result = $classUnderTest->searchBy($searchRequestMock);

        // verify
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function searchBy_orderByTitle_test()
    {
        // prepare
        $expectedResult = ['result 1', 'result 2'];

        /** @var Query|MockObject $queryMock */
        $queryMock = $this->createMock(AbstractQuery::class);

        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->createMock(QueryBuilder::class);
        $queryBuilderMock->expects($this->at(0))
            ->method('select')
            ->willReturnSelf();
        $queryBuilderMock->expects($this->at(1))
            ->method('from');

        $queryBuilderMock->expects($this->at(2))
            ->method('addOrderBy')
            ->with('p.title', 'ASC');

        $queryBuilderMock->expects($this->at(3))
            ->method('setMaxResults')
            ->with(10);
        $queryBuilderMock->expects($this->at(4))
            ->method('setFirstResult')
            ->with(0);

        $queryBuilderMock->expects($this->at(5))
            ->method('getQuery')
            ->willReturn($queryMock);

        $queryMock->method('getResult')->willReturn($expectedResult);

        /** @var EntityManagerInterface|MockObject $entityManagerMock */
        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $entityManagerMock->method('createQueryBuilder')
            ->willReturn($queryBuilderMock);

        /** @var SearchRequest|MockObject $searchRequestMock */
        $searchRequestMock = $this->createMock(SearchRequest::class);
        $searchRequestMock->method('getTitle')->willReturn('');
        $searchRequestMock->method('getBrand')->willReturn('');
        $searchRequestMock->method('getOrderDirection')->willReturn('ASC');
        $searchRequestMock->method('getOrderBy')->willReturn('title');
        $searchRequestMock->method('getLimit')->willReturn(10);
        $searchRequestMock->method('getOffset')->willReturn(0);

        $classUnderTest = new ProductRepository($entityManagerMock);

        // test
        $result = $classUnderTest->searchBy($searchRequestMock);

        // verify
        $this->assertEquals($expectedResult, $result);
    }
}
