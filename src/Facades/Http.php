<?php

namespace Helldar\CashierDriver\SberAuth\Facades;

use Helldar\CashierDriver\SberAuth\Support\Http as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Helldar\CashierDriver\SberAuth\DTO\AccessToken post(string $uri, array $body, array $headers)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
