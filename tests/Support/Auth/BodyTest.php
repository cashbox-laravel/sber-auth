<?php

/*
 * This file is part of the "andrey-helldar/cashier-tinkoff-auth" project.
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
 * @see https://github.com/andrey-helldar/cashier-tinkoff-auth
 */

declare(strict_types=1);

namespace Tests\Support\Auth;

use Helldar\CashierDriver\Sber\Auth\Auth;
use Tests\TestCase;

class BodyTest extends TestCase
{
    public const TOKEN_HASH = '670e06c2ca4d9c73629285eb2201c148c81d587877d1f5836a2f64f45d0f5556';

    public function testBasic()
    {
        $auth = Auth::make($this->model(), $this->request(), false);

        $this->assertIsArray($auth->body());
        $this->assertSame([
            'PaymentId'   => self::PAYMENT_ID,
            'Sum'         => self::SUM_RESULT,
            'Currency'    => self::CURRENCY_RESULT,
            'CreatedAt'   => self::CREATED_AT_RESULT,
            'TerminalKey' => self::TERMINAL_KEY,
            'Token'       => self::TOKEN,
        ], $auth->body());
    }

    public function testHash()
    {
        $auth = Auth::make($this->model(), $this->request());

        $this->assertIsArray($auth->body());
        $this->assertSame([
            'PaymentId'   => self::PAYMENT_ID,
            'Sum'         => self::SUM_RESULT,
            'Currency'    => self::CURRENCY_RESULT,
            'CreatedAt'   => self::CREATED_AT_RESULT,
            'TerminalKey' => self::TERMINAL_KEY,
            'Token'       => self::TOKEN_HASH,
        ], $auth->body());
    }
}
