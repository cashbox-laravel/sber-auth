<?php

namespace Helldar\CashierDriver\SberAuth\Facades;

use Helldar\CashierDriver\SberAuth\DTO\Client;
use Helldar\CashierDriver\SberAuth\Support\Auth as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string accessToken(Client $client)
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
