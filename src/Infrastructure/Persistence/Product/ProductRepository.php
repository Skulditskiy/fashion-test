<?php

namespace Skulditskiy\FashionTest\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Skulditskiy\FashionTest\Domain\Product\Product;
use Skulditskiy\FashionTest\Domain\Product\ProductRepositoryInterface;
use Skulditskiy\FashionTest\Domain\Product\SearchRequest;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function searchBy(SearchRequest $searchRequest): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('p')
            ->from(Product::class, 'p');

        if ($searchRequest->getTitle() !== '') {
            $queryBuilder->andWhere('p.title LIKE :title');
            $queryBuilder->setParameter('title', '%' . $searchRequest->getTitle() . '%');
        }
        if ($searchRequest->getBrand() !== '') {
            $queryBuilder->andWhere('p.brand LIKE :brand');
            $queryBuilder->setParameter('brand', '%' . $searchRequest->getBrand() . '%');
        }

        $orderDirection = null;
        if ($searchRequest->getOrderDirection() !== '' && \in_array($searchRequest->getOrderDirection(), Product::ALLOWED_ORDER_BY_DIRECTION)) {
            $orderDirection = $searchRequest->getOrderDirection();
        }

        $orderBy = $searchRequest->getOrderBy();
        if ($orderBy !== '' && \in_array($orderBy, Product::ALLOWED_ORDER_BY_FIELDS)) {
            switch ($orderBy) {
                case 'title':
                case 'brand':
                case 'stock':
                    $queryBuilder->addOrderBy('p.' . $orderBy, $orderDirection);
                    break;
                case 'price':
                default:
                    $queryBuilder->addOrderBy('p.price.amount', $orderDirection);
                    break;
            }
        }

        $queryBuilder->setMaxResults($searchRequest->getLimit());
        $queryBuilder->setFirstResult($searchRequest->getOffset());

        return $queryBuilder->getQuery()->getResult();
    }
}
