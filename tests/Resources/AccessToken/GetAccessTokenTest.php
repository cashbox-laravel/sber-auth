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

declare(strict_types=1);

namespace Tests\Resources\AccessToken;

use Helldar\CashierDriver\Sber\Auth\Resources\AccessToken;
use Tests\TestCase;

class GetAccessTokenTest extends TestCase
{
    public function testBasic()
    {
        $token = AccessToken::make($this->credentials());

        $this->assertSame($this->clientSecret(), $token->getAccessToken());
    }
}
