<?php

namespace Skulditskiy\FashionTest\Infrastructure\Persistence\Csv;

use Skulditskiy\FashionTest\Domain\Money\Money;
use Skulditskiy\FashionTest\Domain\Product\Factory;
use Skulditskiy\FashionTest\Domain\Product\Product;
use Skulditskiy\FashionTest\Domain\Product\ProductRepositoryInterface;
use Skulditskiy\FashionTest\Domain\Product\SearchRequest;

class ProductRepository implements ProductRepositoryInterface
{

    const COLUMN_KEY_TITLE = 1;
    const COLUMN_KEY_BRAND = 2;
    const COLUMN_KEY_PRICE = 3;
    const COLUMN_KEY_STOCK = 4;

    /**
     * @var string
     */
    private $filePath;
    /**
     * @var Factory
     */
    private $productFactory;
    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * ProductRepository constructor.
     * @param string $filePath
     * @param Factory $productFactory
     * @param FileReader $fileReader
     */
    public function __construct(string $filePath, Factory $productFactory, FileReader $fileReader)
    {
        $this->filePath = $filePath;
        $this->productFactory = $productFactory;
        $this->fileReader = $fileReader;
    }

    /**
     * @param SearchRequest $searchRequest
     * @return Product[]
     */
    public function searchBy(SearchRequest $searchRequest): array
    {
        // filtering
        $filteredResult = [];
        $products = $this->getProductsFromFile($this->filePath);
        foreach ($products as $product) {
            if (empty($searchRequest->getTitle()) || stripos($product->getTitle(), $searchRequest->getTitle()) === false) {
                continue;
            }
            if (empty($searchRequest->getBrand()) || stripos($product->getBrand(), $searchRequest->getBrand()) === false) {
                continue;
            }
            $filteredResult[] = $product;
        }

        // ordering
        $orderBy = $searchRequest->getOrderBy();
        $orderDirection = $searchRequest->getOrderDirection();

        uasort($filteredResult, function(Product $productA, Product $productB) use ($orderBy, $orderDirection) {
            switch ($orderBy) {
                case "title":
                    $orderingFieldValueA = $productA->getTitle();
                    $orderingFieldValueB = $productB->getTitle();
                    break;
                case "brand":
                    $orderingFieldValueA = $productA->getBrand();
                    $orderingFieldValueB = $productB->getBrand();
                    break;
                case "price":
                    $orderingFieldValueA = $productA->getPrice()->getAmount();
                    $orderingFieldValueB = $productB->getPrice()->getAmount();
                    break;
                case "stock":
                    $orderingFieldValueA = $productA->getStock();
                    $orderingFieldValueB = $productB->getStock();
                    break;
            }
            if ($orderDirection === 'ASC') {
                return $orderingFieldValueA < $orderingFieldValueB;
            } else {
                return $orderingFieldValueA > $orderingFieldValueB;
            }
        });

        // paginating
        $paginatedResult = array_slice($filteredResult, $searchRequest->getOffset(), $searchRequest->getLimit());

        return $paginatedResult;
    }

    /**
     * @return Product[]
     * @throws \Exception
     */
    private function getProductsFromFile(): array
    {
        $result = [];
        $productsRawData = $this->fileReader->readFromData($this->filePath);

        foreach ($productsRawData as $productsRawDatum) {
            $title = $productsRawData[self::COLUMN_KEY_TITLE];
            $brand = $productsRawData[self::COLUMN_KEY_BRAND];
            $stock = $productsRawData[self::COLUMN_KEY_STOCK];
            $amount = $productsRawData[self::COLUMN_KEY_PRICE];
            $currency = 'EUR';
            $result[] = $this->productFactory->create($title, $brand, $amount, $currency, $stock);
        }
        return $result;
    }
}
