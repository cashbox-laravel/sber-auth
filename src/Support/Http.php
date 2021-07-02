<?php

namespace Helldar\CashierDriver\SberAuth\Support;

use GuzzleHttp\Client;
use Helldar\CashierDriver\SberAuth\DTO\AccessToken;
use Helldar\CashierDriver\SberAuth\Exceptions\AuthorizationHttpException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Http
{
    public function post(string $uri, array $form_params, array $headers): AccessToken
    {
        try {
            $response = $this->client()->post($uri, compact('headers', 'form_params'));

            if ($this->failed($response)) {
                $this->abort(__FUNCTION__, $uri, $response->getReasonPhrase());
            }

            $decoded = json_decode($response->getBody()->getContents(), true);

            return AccessToken::make($decoded);
        }
        catch (Throwable $e) {
            $this->abort(__FUNCTION__, $uri, $e->getMessage());
        }
    }

    protected function client(): Client
    {
        return new Client();
    }

    protected function abort(string $method, string $uri, string $reason): void
    {
        throw new AuthorizationHttpException($method, $uri, $reason);
    }

    protected function failed(ResponseInterface $response): bool
    {
        $code = $response->getStatusCode();

        return $code < 200 || $code >= 400;
    }
}
