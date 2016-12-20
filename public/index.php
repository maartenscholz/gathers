<?php

use Gathers\Application\ServiceProviders\OpenIdServiceProvider;
use Gathers\Application\ServiceProviders\TemplatingServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\RelayBuilder;

require_once '../vendor/autoload.php';
require_once '../vendor/koraktor/steam-condenser/lib/steam-condenser.php';

session_start();

$container = new League\Container\Container;

$container->delegate(new \League\Container\ReflectionContainer());

$container->addServiceProvider(TemplatingServiceProvider::class);
$container->addServiceProvider(OpenIdServiceProvider::class);

$container->share('response', Zend\Diactoros\Response::class);
$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});

$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$route = new League\Route\RouteCollection($container);

$route->get('/', $container->get(\Gathers\Application\RequestHandlers\DashBoardRequestHandler::class));
$route->get('/login', $container->get(\Gathers\Application\RequestHandlers\LoginRequestHandler::class));
$route->get('/login/steam/openid', $container->get(\Gathers\Application\RequestHandlers\LoginSteamOpenIdRequestHandler::class));
$route->get('/login/steam/openid/callback', $container->get(\Gathers\Application\RequestHandlers\LoginSteamOpenIdCallbackRequestHandler::class));
$route->get('/logout', $container->get(\Gathers\Application\RequestHandlers\LogoutRequestHandler::class));

$relayBuilder = new RelayBuilder();
$relay = $relayBuilder->newInstance([
    new \Gathers\Application\Middleware\AuthorizationMiddleware(),
    function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($route) {
        $response = $route->dispatch($request, $response);

        return $next($request, $response);
    },
]);

$response = $relay($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
