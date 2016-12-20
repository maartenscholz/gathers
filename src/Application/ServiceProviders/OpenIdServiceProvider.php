<?php

namespace Gathers\Application\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use LightOpenID;

class OpenIdServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        LightOpenID::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(LightOpenID::class, function () {
            $openId = new LightOpenID('localhost:8888');

            $openId->identity = 'http://steamcommunity.com/openid';
            $openId->returnUrl = 'http://localhost:8888/login/steam/openid/callback';

            return $openId;
        });
    }
}
