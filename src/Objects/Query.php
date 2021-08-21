<?php

declare(strict_types=1);

namespace Helldar\CashierDriver\Sber\Auth\Objects;

use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\SimpleDataTransferObject\DataTransferObject;

class Query extends DataTransferObject
{
    protected $model;

    protected $scope;

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getScope(): string
    {
        return $this->scope;
    }
}
