<?php

namespace Helldar\CashierDriver\SberAuth\Facades;

use Helldar\CashierDriver\SberAuth\DTO\Client;
use Helldar\CashierDriver\SberAuth\Support\Cache as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string get(Client $client, callable $request)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
