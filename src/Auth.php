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

declare(strict_types=1);

namespace Helldar\CashierDriver\Sber\Auth;

use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Helldar\CashierDriver\Sber\Auth\Support\Hash;
use Helldar\Contracts\Cashier\Auth\Auth as AuthContract;
use Helldar\Contracts\Cashier\Http\Request;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Support\Concerns\Makeable;

/** @method static Auth make(Model $model, Request $request) */
class Auth implements AuthContract
{
    use Makeable;

    /** @var \Helldar\Contracts\Cashier\Resources\Model */
    protected $model;

    /** @var \Helldar\Contracts\Cashier\Http\Request */
    protected $request;

    /** @var string */
    protected $scope;

    public function __construct(Model $model, Request $request, bool $hash = true)
    {
        $this->model   = $model;
        $this->request = $request;
    }

    public function headers(): array
    {
        $token = $this->getAccessToken();

        return array_merge($this->request->getRawHeaders(), [
            'Authorization' => 'Basic ' . $token->getAccessToken(),
        ]);
    }

    public function body(): array
    {
        return $this->request->getRawBody();
    }

    protected function getAccessToken(): AccessToken
    {
        // TODO: Add Scope
        return Hash::make()->get($this->model, $this->request->uri(), $this->scope);
    }
}
