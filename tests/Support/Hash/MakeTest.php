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

namespace Tests\Support\Hash;

use Cashbox\Sber\Auth\Support\Hash;
use Tests\TestCase;

class MakeTest extends TestCase
{
    public function testMake()
    {
        $hash = Hash::make();

        $this->assertInstanceOf(Hash::class, $hash);
    }

    public function testConstruct()
    {
        $hash = new Hash();

        $this->assertInstanceOf(Hash::class, $hash);
    }
}
