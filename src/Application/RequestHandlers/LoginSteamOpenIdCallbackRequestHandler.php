<?php

namespace Gathers\Application\RequestHandlers;

use League\Uri\Schemes\Http;
use LightOpenID;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class LoginSteamOpenIdCallbackRequestHandler
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
        if ($this->openId->validate()) {
            $claimedId = Http::createFromString($this->openId->data['openid_claimed_id']);
            $steamId = $claimedId->path->getSegment(2);
            $_SESSION['steam_id'] = $steamId;
        }

        return new RedirectResponse('/');
    }
}
