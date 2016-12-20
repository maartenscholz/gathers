<?php

namespace Gathers\Application\RequestHandlers;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SteamId;

class DashBoardRequestHandler
{
    /**
     * @var Engine
     */
    private $templates;

    /**
     * @param Engine $templates
     */
    public function __construct(Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $steamId = SteamId::create($_SESSION['steam_id']);

        $response->getBody()->write($this->templates->render('dashboard', [
            'name' => $steamId->getNickname(),
            'avatarUrl' => $steamId->getMediumAvatarUrl(),
        ]));

        return $response;
    }
}
