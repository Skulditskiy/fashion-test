<?php

use Skulditskiy\FashionTest\Application\Bootstrap\DiKeys;

$apiAuthenticationMiddleware = new Tuupola\Middleware\HttpBasicAuthentication([
    'users' => $container->get(DiKeys::APPLICATION_CONFIG)['apiUsers'],
    'secure' => false,
]);

$application->get(
    '/v1/products',
    function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $arguments) use ($container) {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $container->get(DiKeys::ACTION_PRODUCTS_SEARCH_GET_V10)->execute($request, $response, $arguments);
        return $response->withHeader('Content-Type', 'application/json');
    }
)->add($apiAuthenticationMiddleware);
