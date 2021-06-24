<?php

namespace Helldar\CashierDriver\SberAuth\Facades;

use Helldar\CashierDriver\SberAuth\Support\Http as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array post(string $uri, array $data, array $headers)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
