<?php

$projectPath = dirname(__DIR__) ;

require $projectPath . '/vendor/autoload.php';

require $projectPath . '/src/Application/Bootstrap/dependencies.php';
require $projectPath . '/src/Application/Bootstrap/routes.php';

try {
    $container->get(\Skulditskiy\FashionTest\Application\Bootstrap\DiKeys::ACTION_PRODUCTS_SEARCH_GET_V10);
    die();

    $application->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
} catch (\Slim\Exception\NotFoundException $e) {
} catch (Exception $e) {
}
