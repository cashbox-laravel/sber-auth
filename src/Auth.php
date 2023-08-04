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
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Sber\Auth;

use Cashbox\Core\Data\Signing\Token;
use Cashbox\Core\Services\Auth as BaseAuth;
use Cashbox\Core\Services\Identifier;
use Cashbox\Sber\Auth\Services\Hash;
use Illuminate\Support\Arr;

class Auth extends BaseAuth
{
    public function headers(): array
    {
        return array_merge(parent::headers(), [
            'X-IBM-Client-Id'    => $this->config->credentials->clientId,
            'x-Introspect-RqUID' => $this->uniqueId(),
            'Authorization'      => $this->bearer(),
        ]);
    }

    protected function bearer(): string
    {
        return 'Bearer ' . $this->token()->clientSecret;
    }

    protected function token(): Token
    {
        return Hash::get(
            $this->config->credentials,
            $this->request->resource->paymentId(),
            $this->extra('url'),
            $this->extra('scope'),
        );
    }

    protected function uniqueId(): string
    {
        return Identifier::getUnique();
    }

    protected function extra(string $key): mixed
    {
        return Arr::get($this->extra, $key);
    }
}
