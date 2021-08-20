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

namespace Tests\Fixtures;

use Helldar\Cashier\Resources\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ModelResource extends Model
{
    protected function clientId(): string
    {
        return TestCase::TERMINAL_KEY;
    }

    protected function clientSecret(): string
    {
        return TestCase::TOKEN;
    }

    protected function paymentId(): string
    {
        return TestCase::PAYMENT_ID;
    }

    protected function sum(): float
    {
        return TestCase::SUM;
    }

    protected function currency(): int
    {
        return TestCase::CURRENCY;
    }

    protected function createdAt(): Carbon
    {
        return Carbon::parse(TestCase::CREATED_AT);
    }
}
