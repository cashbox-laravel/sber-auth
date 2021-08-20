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

use Helldar\Cashier\Http\Request as BaseRequest;

class Request extends BaseRequest
{
    public function getRawHeaders(): array
    {
        return ['Accept' => 'application/json'];
    }

    public function getRawBody(): array
    {
        return [
            'PaymentId' => $this->model->getPaymentId(),
            'Sum'       => $this->model->getSum(),
            'Currency'  => $this->model->getCurrency(),
            'CreatedAt' => $this->model->getCreatedAt(),
        ];
    }
}
