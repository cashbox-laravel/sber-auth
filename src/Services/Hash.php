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

use Carbon\Carbon;
use Cashbox\Core\Data\Config\Drivers\CredentialsData;
use Cashbox\Core\Data\Signing\Token;
use DragonCode\Cache\Services\Cache;

class Hash
{
    public static function get(CredentialsData $credentials, string $paymentId, string $url, ?string $scope): Token
    {
        $cache = static::cache($credentials->clientId, $paymentId, $scope);

        if ($cache->has()) {
            return $cache->get();
        }

        $response = static::request($credentials, $paymentId, $url, $scope);

        return $cache->ttl($response->expiresIn)->remember(fn () => $response);
    }

    protected static function cache(mixed ...$keys): Cache
    {
        return Cache::make()->key(static::class, $keys);
    }

    protected static function request(
        CredentialsData $credentials,
        string $paymentId,
        string $url,
        ?string $scope
    ): Token {
        $response = Http::get($credentials, $paymentId, $url, $scope);

        return Token::from([
            'clientId'     => $response['client_id'],
            'clientSecret' => $response['access_token'],
            'expiresIn'    => static::expiresIn($response['expires_in']),
        ]);
    }

    protected static function expiresIn(int $seconds): Carbon
    {
        return Carbon::now()->addSeconds($seconds);
    }
}
