<?php

namespace Helldar\CashierDriver\Sber\Auth\DTO;

use Helldar\Cashier\Facades\Unique;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Http\Builder;
use Psr\Http\Message\UriInterface;

class Client
{
    use Makeable;

    /** @var \Helldar\Support\Helpers\Http\Builder */
    protected $http;

    protected $client_id;

    protected $client_secret;

    protected $member_id;

    protected $payment_id;

    protected $scope;

    protected $grant_type = 'client_credentials';

    protected $uri = 'ru/prod/tokens/v2/oauth';

    public function host($host): Client
    {
        $this->http = Builder::parse($host);

        return $this;
    }

    public function clientId(string $client_id): Client
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function clientSecret(string $client_secret): Client
    {
        $this->client_secret = $client_secret;

        return $this;
    }

    public function memberId(string $member_id): Client
    {
        $this->member_id = $member_id;

        return $this;
    }

    public function getMemberId(): string
    {
        return $this->member_id;
    }

    public function paymentId($payment_id): Client
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }

    public function scope($scope): Client
    {
        $this->scope = $scope;

        return $this;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function url(): UriInterface
    {
        return $this->http->withPath($this->uri);
    }

    public function headers(): array
    {
        return [
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/x-www-form-urlencoded',
            'Authorization'   => 'Basic '.$this->authorization(),
            'X-IBM-Client-Id' => $this->getClientId(),
            'RqUID'           => $this->rqUID(),
        ];
    }

    public function data(): array
    {
        return [
            'grant_type' => $this->grant_type,
            'scope'      => $this->scope,
        ];
    }

    protected function authorization(): string
    {
        $client = $this->client_id;
        $secret = $this->client_secret;

        return base64_encode($client.':'.$secret);
    }

    protected function rqUID(): string
    {
        return Unique::uid();
    }
}
