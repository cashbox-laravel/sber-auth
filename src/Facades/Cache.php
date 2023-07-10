<?php

/*
 * This file is part of the "andrey-helldar/cashier-sber-auth" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier-sber-auth
 */

declare(strict_types=1);

namespace SberAuth\src\Facades;

use SberAuth\src\Objects\Query;
use SberAuth\src\Resources\AccessToken;
use SberAuth\src\Support\Cache as Support;
use Illuminate\Support\Facades\Facade;

/**
 * @method static AccessToken get(Query $client, callable $request)
 * @method static void forget(Query $client)
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
