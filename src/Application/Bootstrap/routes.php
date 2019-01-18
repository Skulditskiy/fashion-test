<?php

use Skulditskiy\FashionTest\Application\Bootstrap\DiKeys;


$application->get(
    '/v1/products',
    function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $arguments) use ($container) {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $container->get(DiKeys::ACTION_PRODUCTS_SEARCH_GET_V10)->execute($request, $response, $arguments);
        return $response->withHeader('Content-Type', 'application/json');
    }
);

$application->get(
    '[/]',
    function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $arguments) use ($container) {
        /** @var \Slim\Views\Twig $view */
        $view = $container->get(DiKeys::VIEW);
        return $view->render(
            $response,
            'demo.twig',
            []
        );
    }
);