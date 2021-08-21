<?php

declare(strict_types=1);

namespace Helldar\CashierDriver\Sber\Auth\Support;

use DateTimeInterface;
use Helldar\CashierDriver\Sber\Auth\Objects\Client;
use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache as Repository;

class Cache
{
    public function get(Client $client, callable $request): string
    {
        $key = $this->key($client);

        if ($this->doesnt($key)) {
            $response = $this->request($client, $request);

            $this->set($key, $response->getExpiresIn(), $response->getAccessToken());

            return $response->getAccessToken();
        }

        return $this->from($key);
    }

    protected function doesnt(string $key): bool
    {
        return ! Repository::has($key);
    }

    protected function from(string $key): string
    {
        return Repository::get($key);
    }

    protected function set(string $key, DateTimeInterface $ttl, string $token): void
    {
        Repository::put($key, $token, $ttl);
    }

    protected function request(Client $client, callable $request): AccessToken
    {
        return $request($client);
    }

    protected function key(Client $client): string
    {
        $client_id  = $client->getClientId();
        $member_id  = $client->getMemberId();
        $payment_id = $client->getPaymentId();
        $scope      = $client->getScope();

        return Collection::make([self::class, $client_id, $member_id, $payment_id, $scope])
            ->map(static function ($value) {
                return md5($value);
            })->implode('::');
    }
}
