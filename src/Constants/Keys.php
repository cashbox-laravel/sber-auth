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

namespace Helldar\CashierDriver\Sber\Auth\Constants;

class Keys
{
    public const TERMINAL = 'X-IBM-Client-Id';

    public const TOKEN = 'Token';

    public const PASSWORD = 'Password';

    public const EXPIRES_IN = 'ExpiresIn';
}
