<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashbox-laravel/foundation
 */

declare(strict_types=1);

namespace Cashbox\Sber\Auth\Facades;

use Cashbox\Sber\Auth\Objects\Query;
use Cashbox\Sber\Auth\Resources\AccessToken;
use Cashbox\Sber\Auth\Support\Cache as Support;
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
