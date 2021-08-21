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

namespace Helldar\CashierDriver\Sber\Auth\Support;

use DateTimeInterface;
use Helldar\CashierDriver\Sber\Auth\Objects\Query;
use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache as Repository;

class Cache
{
    public function get(Query $client, callable $request): AccessToken
    {
        $key = $this->key($client);

        if ($this->doesnt($key)) {
            $response = $this->request($client, $request);

            $this->set($key, $response->getExpiresIn(), $response->getAccessToken());

            return $response;
        }

        return $this->from($key, $client);
    }

    protected function doesnt(string $key): bool
    {
        return ! Repository::has($key);
    }

    protected function from(string $key, Query $client): AccessToken
    {
        $client_id = $client->getModel()->getClientId();

        $access_token = Repository::get($key);

        return AccessToken::make(compact('client_id', 'access_token'));
    }

    protected function set(string $key, DateTimeInterface $ttl, string $token): void
    {
        Repository::put($key, $token, $ttl);
    }

    protected function request(Query $client, callable $request): AccessToken
    {
        return $request($client);
    }

    protected function key(Query $client): string
    {
        return $this->compact([
            self::class,
            $client->getModel()->getClientId(),
            $client->getModel()->getPaymentId(),
            $client->getScope(),
        ]);
    }

    protected function compact(array $values): string
    {
        return Collection::make($values)
            ->map(static function ($value) {
                return md5($value);
            })->implode('::');
    }
}
