<?php

namespace Helldar\CashierDriver\Sber\Auth\Exceptions;

use RuntimeException;

class AuthorizationHttpException extends RuntimeException
{
    protected $template = 'Unable to complete authorization request in Sber: %s %s %s';

    public function __construct(string $method, string $url, string $reason)
    {
        parent::__construct($this->message($method, $url, $reason));
    }

    protected function message(string $method, string $url, string $reason = null): string
    {
        return sprintf($this->template, $method, $url, $reason);
    }
}
