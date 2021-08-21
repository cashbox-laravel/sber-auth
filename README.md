# Sber Auth Cashier Driver

Sber API Authorization Driver.

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Installation

To get the latest version of `Sber Auth Cashier Driver`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/cashier-sber-auth
```

Or manually update `require` block of `composer.json` and run `composer update`.

```json
{
    "require": {
        "andrey-helldar/cashier-sber-auth": "^1.0"
    }
}
```

## Using

```php
namespace Helldar\CashierDriver\Sber\QrCode\Requests;

use Helldar\Cashier\Http\Request;
use Helldar\CashierDriver\Sber\Auth\Auth;
use Helldar\CashierDriver\Sber\QrCode\Constants\Body;
use Helldar\CashierDriver\Sber\QrCode\Constants\Scopes;

class Create extends Request
{
    protected $production_host = 'https://api.sberbank.ru';
    
    protected $dev_host = 'https://dev.api.sberbank.ru';

    protected $path = '/ru/prod/order/v1/creation';
    
    protected $auth = Auth::class;
    
    protected $auth_extra = [
        Body::SCOPE => Scopes::CREATE,
    ];
    
    public function getRawBody(): array
    {
        return [
            Body::REQUEST_ID   => $this->uniqueId(),
            Body::REQUEST_TIME => $this->currentTime(),

            Body::MEMBER_ID   => $this->model->getMemberId(),
            Body::TERMINAL_ID => $this->model->getTerminalId(),

            Body::ORDER_ID         => $this->model->getPaymentId(),
            Body::ORDER_SUM        => $this->model->getSum(),
            Body::ORDER_CURRENCY   => $this->model->getCurrency(),
            Body::ORDER_CREATED_AT => $this->model->getCreatedAt(),
        ];
    }
}
```

```php
namespace Helldar\CashierDriver\Sber\QrCode;

use Helldar\CashierDriver\Sber\Auth\Support\Auth;
use Helldar\CashierDriver\Sber\QrCode\Driver as BaseDriver;
use Helldar\CashierDriver\Sber\QrCode\Requests\Init;
use Helldar\Contracts\Cashier\Resources\Response;

class Driver extends BaseDriver
{
    public function start(): Response
    {
        $request = Create::make($this->model);

        return $this->request($request, Response::class);
    }
}
```

## For Enterprise

Available as part of the Tidelift Subscription.

The maintainers of `andrey-helldar/cashier` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source packages you
use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact packages you
use. [Learn more](https://tidelift.com/subscription/pkg/packagist-andrey-helldar-cashier?utm_source=packagist-andrey-helldar-cashier&utm_medium=referral&utm_campaign=enterprise&utm_term=repo)
.

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/cashier-sber-auth.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/cashier-sber-auth.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/cashier-sber-auth?label=stable&style=flat-square

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/andrey-helldar/cashier-sber-auth
