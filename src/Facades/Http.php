<?php

namespace Helldar\CashierDriver\Sber\Auth\Facades;

use Helldar\CashierDriver\Sber\Auth\Support\Http as Support;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\UriInterface;

/**
 * @method static \Helldar\CashierDriver\Sber\Auth\DTO\AccessToken post(UriInterface $uri, array $body, array $headers)
 */
class Http extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
