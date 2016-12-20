<?php

namespace Gathers\Application\RequestHandlers;

use LightOpenID;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class LoginSteamOpenIdRequestHandler
{
    /**
     * @var LightOpenID
     */
    private $openId;

    /**
     * @param LightOpenID $openId
     */
    public function __construct(LightOpenID $openId)
    {
        $this->openId = $openId;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return new RedirectResponse($this->openId->authUrl());
    }
}
