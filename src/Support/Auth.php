<?php

namespace Helldar\CashierDriver\SberAuth\Support;

use Helldar\CashierDriver\SberAuth\DTO\AccessToken;
use Helldar\CashierDriver\SberAuth\DTO\Client;
use Helldar\CashierDriver\SberAuth\Facades\Cache as Facade;
use Helldar\CashierDriver\SberAuth\Facades\Http;

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

    protected function request(string $url, array $data, array $headers): AccessToken
    {
        return Http::post($url, $data, $headers);
    }
}
