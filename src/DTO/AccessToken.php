<?php

namespace Helldar\CashierDriver\Sber\Auth\DTO;

use Carbon\Carbon;
use Helldar\Support\Concerns\Makeable;

class AccessToken
{
    use Makeable;

    protected $access_token;

    protected $expires_in;

    protected $scope;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getExpiresIn(): Carbon
    {
        return Carbon::now()->addSeconds($this->expires_in - 10);
    }

    public function getScope(): string
    {
        return $this->scope;
    }
}
