<?php

declare(strict_types=1);

namespace Helldar\CashierDriver\Sber\Auth\Facades;

use Helldar\CashierDriver\Sber\Auth\Objects\Query;
use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Helldar\CashierDriver\Sber\Auth\Support\Cache as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static AccessToken get(Query $client, callable $request)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
