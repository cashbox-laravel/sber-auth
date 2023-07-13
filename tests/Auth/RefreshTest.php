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

namespace Tests\Auth;

use CashierProvider\Sber\Auth\Auth;
use DragonCode\Contracts\Cashier\Resources\Model;
use DragonCode\Support\Facades\Helpers\Arr;
use Tests\TestCase;

class RefreshTest extends TestCase
{
    public function testBasic()
    {
        $model = $this->model();

        $first  = Arr::get($this->makeAuth($model)->headers(), 'Authorization');
        $second = Arr::get($this->makeAuth($model)->headers(), 'Authorization');

        $this->makeAuth($model)->refresh();

        $third  = Arr::get($this->makeAuth($model)->headers(), 'Authorization');
        $fourth = Arr::get($this->makeAuth($model)->headers(), 'Authorization');

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

    protected function makeAuth(Model $model): Auth
    {
        return Auth::make($model, $this->request(), true, [
            'scope' => self::SCOPE_CREATE,
        ]);
    }
}
