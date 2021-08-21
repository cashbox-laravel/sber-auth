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

namespace Helldar\CashierDriver\Sber\Auth\Exceptions;

use Helldar\Cashier\Exceptions\Http\UnauthorizedException;
use Helldar\Cashier\Exceptions\Manager as ExceptionManager;

class Manager extends ExceptionManager
{
    protected $codes = [
        401 => UnauthorizedException::class,
    ];

    protected $code_keys = ['httpCode'];
}
