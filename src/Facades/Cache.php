<?php

namespace Helldar\CashierDriver\Sber\Auth\Facades;

use Helldar\CashierDriver\Sber\Auth\DTO\Client;
use Helldar\CashierDriver\Sber\Auth\Support\Cache as Support;
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
