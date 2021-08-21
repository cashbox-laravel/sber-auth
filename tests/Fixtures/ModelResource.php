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

namespace Tests\Fixtures;

use Helldar\Cashier\Resources\Model;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ModelResource extends Model
{
    protected function clientId(): string
    {
        return config('cashier.drivers.sber_qr.client_id');
    }

    protected function clientSecret(): string
    {
        return config('cashier.drivers.sber_qr.client_secret');
    }

    protected function memberId(): string
    {
        return config('cashier.drivers.sber_qr.member_id');
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
