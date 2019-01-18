<?php

use Skulditskiy\FashionTest\Application\Bootstrap\DiKeys;

$container = new \Slim\Container([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

define('PROJECT_PATH', dirname(__DIR__, 3));

$container[DiKeys::APPLICATION_CONFIG] = function () {
    $yamlParser = new \Symfony\Component\Yaml\Parser();
    return $yamlParser->parseFile(PROJECT_PATH . '/src/Application/Config/config.yaml');
};

$container[DiKeys::ENTITY_MANAGER] = function (\Slim\Container $container) {
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        [],
        true,
        PROJECT_PATH . '/cache/proxies',
        null,
        false
    );
    return \Doctrine\ORM\EntityManager::create(
        [
            'driver' => 'pdo_mysql',
            'host' => 'mysql',
            'dbname' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        $config
    );
};

$container[DiKeys::PRODUCT_CSV_REPOSITORY] = function (\Slim\Container $container) {
    $csvFilePath = $container->get(DiKeys::APPLICATION_CONFIG)['product']['csvRepositoryPath'];
    return new \Skulditskiy\FashionTest\Infrastructure\Persistence\Csv\ProductRepository(
        $csvFilePath,
        new \Skulditskiy\FashionTest\Domain\Product\Factory(),
        new \Skulditskiy\FashionTest\Infrastructure\Persistence\Csv\FileReader()
    );
};

$container[DiKeys::ACTION_PRODUCTS_SEARCH_GET_V10] = function (\Slim\Container $container) {
    return new \Skulditskiy\FashionTest\Infrastructure\Controllers\V10\ProductsSearch(
        $container->get(DiKeys::PRODUCT_CSV_REPOSITORY),
        new \Skulditskiy\FashionTest\Domain\Product\SearchRequestFactory(),
        new \Skulditskiy\FashionTest\Application\RequestFilters\ProductsSearchRequestFilter()
    );
};

$container[DiKeys::VIEW] = function (\Slim\Container $container) {
    $view = new \Slim\Views\Twig(PROJECT_PATH .'/views', [
        'cache' => false,
        'debug' => true,
    ]);
    
    return $view;
};

$application = new \Slim\App($container);
