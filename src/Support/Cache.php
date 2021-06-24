<?php

namespace Helldar\CashierDriver\SberAuth\Support;

use DateTimeInterface;
use Helldar\CashierDriver\SberAuth\DTO\Client;
use Illuminate\Support\Facades\Cache as Repository;

class Cache
{
    public function get(Client $client, callable $request): string
    {
        $key = $this->key($client);

        if (! $this->has($key)) {
            ['token' => $token, 'ttl' => $ttl] = $this->request($client, $request);

            $this->set($key, $ttl, $token);

            return $token;
        }

        return $this->from($key);
    }

    protected function has(string $key): bool
    {
        return Repository::has($key);
    }

    protected function from(string $key): string
    {
        return Repository::get($key);
    }

    protected function set(string $key, DateTimeInterface $ttl, string $token): void
    {
        Repository::put($key, $ttl, $token);
    }

    protected function request(Client $client, callable $request): array
    {
        return $request($client);
    }

    protected function key(Client $client): string
    {
        $client_id = $client->getClientId();
        $unique_id = $client->getUniqueId();

        return implode('::', [md5(self::class), md5($client_id), md5($unique_id)]);
    }
}
