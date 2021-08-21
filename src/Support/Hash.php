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

namespace Helldar\CashierDriver\Sber\Auth\Support;

use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\CashierDriver\Sber\Auth\Objects\Client;
use Helldar\CashierDriver\Sber\Auth\Http\Request;
use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Helldar\Contracts\Cashier\Http\Request as RequestContract;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Concerns\Makeable;

class Hash
{
    use Makeable;

    public function get(Model $model, Builder $uri, string $scope): AccessToken
    {
        return \Helldar\CashierDriver\Sber\Auth\Facades\Cache::get($client, function (Client $client) use ($model, $uri, $scope) {
            $request = $this->request($model, $uri, $scope);

            $response = $this->post($request);

            return $this->makeToken($response);
        });
    }

    protected function post(RequestContract $request): array
    {
        return Http::post($request);
    }

    protected function request(Model $model, Builder $uri, string $scope): RequestContract
    {
        return Request::make($model)
            ->setHost($uri->getBaseUrl())
            ->setScope($scope);
    }

    protected function makeToken(array $response): AccessToken
    {
        return AccessToken::make($response);
    }
}
