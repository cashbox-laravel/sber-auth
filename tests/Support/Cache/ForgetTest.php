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

namespace Tests\Support\Cache;

use Cashbox\Sber\Auth\Support\Hash;
use Illuminate\Support\Facades\Cache as CacheRepository;

class ForgetTest extends BaseTest
{
    public function testBasic()
    {
        $key = $this->getKey();

        $this->getCache();
        $first = CacheRepository::get($key);

        $this->getCache();
        $second = CacheRepository::get($key);

        Hash::make()->forget($this->model(), self::SCOPE_CREATE);

        $this->getCache();
        $third = CacheRepository::get($key);

        $this->getCache();
        $fourth = CacheRepository::get($key);

        $this->assertIsString($first);
        $this->assertIsString($second);
        $this->assertIsString($third);
        $this->assertIsString($fourth);

        $this->assertSame($first, $second);
        $this->assertSame($third, $fourth);

        $this->assertNotSame($first, $third);
        $this->assertNotSame($first, $fourth);

        $this->assertNotSame($second, $third);
        $this->assertNotSame($second, $fourth);
    }
}
