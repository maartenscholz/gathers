<?php

namespace Gathers\Application\RequestHandlers;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;

class LogoutRequestHandler
{
    /**
     * @return ResponseInterface
     */
    public function __invoke()
    {
        session_destroy();

        return new RedirectResponse('/');
    }
}
