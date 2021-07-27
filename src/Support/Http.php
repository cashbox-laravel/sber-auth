<?php

namespace Helldar\CashierDriver\Sber\Auth\Support;

use Helldar\Cashier\Facades\Helpers\Http as CashierHttp;
use Helldar\CashierDriver\Sber\Auth\DTO\AccessToken;
use Helldar\CashierDriver\Sber\Auth\Exceptions\AuthorizationHttpException;
use Psr\Http\Message\UriInterface;
use Throwable;

class Http
{
    public function post(UriInterface $uri, array $body, array $headers): AccessToken
    {
        try {
            $response = CashierHttp::post($uri, $body, $headers);

            return AccessToken::make($response);
        } catch (Throwable $e) {
            $this->abort(__FUNCTION__, $uri, $e->getMessage());
        }
    }

    protected function abort(string $method, string $uri, string $reason): void
    {
        throw new AuthorizationHttpException($method, $uri, $reason);
    }
}
