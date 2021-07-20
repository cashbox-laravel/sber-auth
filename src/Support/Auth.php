<?php

namespace Helldar\CashierDriver\Sber\Auth\Support;

use Helldar\CashierDriver\Sber\Auth\DTO\AccessToken;
use Helldar\CashierDriver\Sber\Auth\DTO\Client;
use Helldar\CashierDriver\Sber\Auth\Facades\Cache as Facade;
use Helldar\CashierDriver\Sber\Auth\Facades\Http;
use Psr\Http\Message\UriInterface;

class Auth
{
    public function accessToken(Client $client): string
    {
        return Facade::get($client, function (Client $client) {
            return $this->request(
                $client->url(),
                $client->data(),
                $client->headers()
            );
        });
    }

    protected function request(UriInterface $url, array $data, array $headers): AccessToken
    {
        return Http::post($url, $data, $headers);
    }
}
