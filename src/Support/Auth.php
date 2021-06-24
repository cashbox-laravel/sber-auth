<?php

namespace Helldar\CashierDriver\SberAuth\Support;

use Carbon\Carbon;
use DateTimeInterface;
use Helldar\Cashier\Facade\Http;
use Helldar\CashierDriver\SberAuth\DTO\Client;
use Helldar\CashierDriver\SberAuth\Facades\Cache as Facade;
use Helldar\Support\Facades\Helpers\Arr;

class Auth
{
    public function accessToken(Client $client): string
    {
        return Facade::get($client, function (Client $client) {
            return $this->request(
                $client->url(),
                $client->headers(),
                $client->data()
            );
        });
    }

    protected function request(string $url, array $headers, array $data): array
    {
        $response = Http::post($url, $headers, $data);

        $token = $this->token($response);
        $ttl   = $this->ttl($response);

        return compact('token', 'ttl');
    }

    protected function token(array $response): string
    {
        return Arr::get($response, 'access_token');
    }

    protected function ttl(array $response): DateTimeInterface
    {
        $expires_in = Arr::get($response, 'expires_in');

        $ttl = abs($expires_in - 10);

        return Carbon::now()->addSeconds(
            $ttl > 0 ? $ttl : 30
        );
    }
}
