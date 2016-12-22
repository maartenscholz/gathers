<?php

namespace Gathers\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AuthorizationMiddleware
{
    /**
     * @var array
     */
    private $protectedUris = [
        '/',
    ];

    /**
     * @var array
     */
    private $unprotectedUris = [
        '/login',
    ];

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($this->isProtectedRequest($request) && !$this->userIsLoggedIn()) {
            return new RedirectResponse('/login');
        }

        if ($this->isUnprotectedRequest($request) && $this->userIsLoggedIn()) {
            return new RedirectResponse('/');
        }

        return $next($request, $response);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    private function isProtectedRequest(ServerRequestInterface $request)
    {
        return in_array($request->getUri()->getPath(), $this->protectedUris);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return bool
     */
    private function isUnprotectedRequest(ServerRequestInterface $request)
    {
        return in_array($request->getUri()->getPath(), $this->unprotectedUris);
    }



    /**
     * @return bool
     */
    public function userIsLoggedIn()
    {
        return isset($_SESSION['steam_id']);
    }
}
