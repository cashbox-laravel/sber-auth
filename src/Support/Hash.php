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

namespace Helldar\CashierDriver\Sber\Auth\Support;

use Helldar\Cashier\Facades\Helpers\Http;
use Helldar\CashierDriver\Sber\Auth\Constants\Keys;
use Helldar\CashierDriver\Sber\Auth\Exceptions\Manager as ExceptionManager;
use Helldar\CashierDriver\Sber\Auth\Facades\Cache as CacheRepository;
use Helldar\CashierDriver\Sber\Auth\Http\Request;
use Helldar\CashierDriver\Sber\Auth\Objects\Query;
use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Helldar\Contracts\Cashier\Http\Request as RequestContract;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Exceptions\Manager;
use Helldar\Contracts\Http\Builder;
use Helldar\Support\Concerns\Makeable;

class Hash
{
    use Makeable;

    public function get(Model $model, Builder $uri, string $scope): AccessToken
    {
        $query = $this->query($model, $scope);

        return CacheRepository::get($query, function (Query $query) use ($uri) {
            $request = $this->request($query->getModel(), $uri, $query->getScope());

            $response = $this->post($request);

            return $this->makeToken(array_merge($response, [
                Keys::CLIENT_ID => $query->getModel()->getClientId(),
            ]));
        });
    }

    protected function post(RequestContract $request): array
    {
        return Http::post($request, $this->exceptions());
    }

    protected function query(Model $model, string $scope): Query
    {
        return Query::make(compact('model', 'scope'));
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

    protected function exceptions(): Manager
    {
        return new ExceptionManager();
    }
}
