<?php

/**
 * This file is part of the "cashbox/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://cashbox.city
 */

declare(strict_types=1);

namespace Cashbox\Sber\Auth\Services;

use Cashbox\Core\Concerns\Config\Application;
use Cashbox\Core\Data\Config\Drivers\CredentialsData;
use Cashbox\Core\Services\Identifier;
use DragonCode\Support\Facades\Http\Url;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http as Client;

class Http
{
    use Application;

    protected static string $uri = 'ru/prod/tokens/v2/oauth';

    protected static string $grantType = 'client_credentials';

    protected static int $retryTimes = 5;

    protected static int $retrySleep = 300;

    public static function get(CredentialsData $credentials, string $paymentId, string $url, ?string $scope): array
    {
        return Client::baseUrl(static::host($url))
            ->withHeader('X-IBM-Client-Id', $credentials->clientId)
            ->withHeader('RqUID', static::generateId($paymentId))
            ->withHeader('Authorization', static::authorization($credentials))
            ->when(static::isProduction(), fn (PendingRequest $request) => $request->mergeOptions(
                static::certificate($credentials)
            ))
            ->retry(static::$retryTimes, static::$retrySleep)
            ->acceptJson()
            ->asForm()
            ->throw()
            ->post(static::$uri, static::data($scope))
            ->json();
    }

    protected static function data(?string $scope): array
    {
        return [
            'grant_type' => static::$grantType,
            'scope'      => $scope,
        ];
    }

    protected static function certificate(CredentialsData $credentials): array
    {
        return [
            'cert' => [
                $credentials->extra['certificate_path'],
                $credentials->extra['certificate_password'],
            ],
        ];
    }

    protected static function authorization(CredentialsData $credentials): string
    {
        return base64_encode($credentials->clientId . ':' . $credentials->clientSecret);
    }

    protected static function host(string $url): string
    {
        return Url::parse($url)->getBaseUrl();
    }

    protected static function generateId(string $paymentId): string
    {
        return Identifier::getStatic($paymentId);
    }
}
