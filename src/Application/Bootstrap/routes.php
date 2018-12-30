<?php

use Skulditskiy\FashionTest\Application\Bootstrap\DiKeys;

$apiAuthenticationMiddleware = new Tuupola\Middleware\HttpBasicAuthentication([
    'users' => $container->get(DiKeys::APPLICATION_CONFIG)['apiUsers'],
    'secure' => false,
]);

$application->get(
    '/products',
    function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $arguments) use ($container) {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $container->get(DiKeys::ACTION_PRODUCTS_SEARCH_GET)->execute($request, $response, $arguments);
        return $response->withHeader('Content-Type', 'application/json');
    }
)->add($apiAuthenticationMiddleware);
