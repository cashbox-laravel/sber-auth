<?php

namespace Helldar\CashierDriver\Sber\Auth\Facades;

use Helldar\CashierDriver\Sber\Auth\DTO\Client;
use Helldar\CashierDriver\Sber\Auth\Support\Auth as Support;
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
