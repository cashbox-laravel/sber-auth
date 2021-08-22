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

namespace Tests\Support\Cache;

use Helldar\CashierDriver\Sber\Auth\Objects\Query;
use Helldar\CashierDriver\Sber\Auth\Support\Cache;
use Helldar\CashierDriver\Sber\Auth\Support\Hash;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Http\Builder as BuilderContract;
use Helldar\Support\Facades\Http\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache as CacheRepository;
use Tests\TestCase;

class CacheableTest extends TestCase
{
    protected $uri = 'https://dev.api.sberbank.ru/ru/prod/order/v1/creation';

    public function testSet()
    {
        $key = $this->getKey();

        $this->assertFalse(CacheRepository::has($key));

        $this->getCache();

        $this->assertTrue(CacheRepository::has($key));

        $this->assertIsString(CacheRepository::get($key));
    }

    protected function uri(): BuilderContract
    {
        return Builder::parse($this->uri);
    }

    protected function getCache(): string
    {
        $model = $this->model();

        $uri = Builder::parse($this->uri);

        $token = Hash::make()->get($model, $uri, self::SCOPE_CREATE);

        return $token->getAccessToken();
    }

    protected function query(Model $model, string $scope): Query
    {
        return Query::make(compact('model', 'scope'));
    }

    protected function getKey(): string
    {
        $model = $this->model();

        $query = $this->query($model, self::SCOPE_CREATE);

        return $this->key($query);
    }

    protected function key(Query $query): string
    {
        return $this->compact([
            Cache::class,
            $query->getModel()->getClientId(),
            $query->getModel()->getPaymentId(),
            $query->getScope(),
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
