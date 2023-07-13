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

use Cashbox\Sber\Auth\Auth;
use Tests\TestCase;

class BodyTest extends TestCase
{
    public function testBasic()
    {
        $auth = Auth::make($this->model(), $this->request());

        $this->assertIsArray($auth->body());

        $this->assertSame([
            'PaymentId' => self::PAYMENT_ID,
            'Sum'       => self::SUM_RESULT,
            'Currency'  => self::CURRENCY_RESULT,
            'CreatedAt' => self::CREATED_AT_RESULT,
        ], $auth->body());
    }
}
