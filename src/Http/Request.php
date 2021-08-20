<?php

declare(strict_types=1);

namespace Helldar\CashierDriver\Sber\Auth\Http;

use Helldar\Cashier\Facades\Helpers\Unique;
use Helldar\Cashier\Http\Request as BaseRequest;
use Helldar\Contracts\Cashier\Resources\Model;

/**
 * @method static Request make(Model $model)
 */
class Request extends BaseRequest
{
    protected $path = 'ru/prod/tokens/v2/oauth';

    protected $grant_type = 'client_credentials';

    protected $scope;

    public function setHost(string $host): self
    {
        $this->production_host = $host;
        $this->dev_host        = $host;

        return $this;
    }

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getRawHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',

            'Authorization' => 'Basic ' . $this->authorization(),

            'X-IBM-Client-Id' => $this->model->getClientId(),

            'RqUID' => $this->rqUID(),
        ];
    }

    public function getRawBody(): array
    {
        return [
            'grant_type' => $this->grant_type,
            'scope'      => $this->scope,
        ];
    }

    protected function authorization(): string
    {
        return base64_encode($this->model->getClientId() . ':' . $this->model->getClientSecret());
    }

    protected function rqUID(): string
    {
        return Unique::id();
    }
}
