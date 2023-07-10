<?php

/**
 * This file is part of the "cashier-provider/foundation" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2023 Andrey Helldar
 * @license MIT
 *
 * @see https://github.com/cashier-provider/foundation
 */

namespace CashierProvider\Sber\Auth\Exceptions;

use CashierProvider\Core\Exceptions\Http\UnauthorizedException;
use CashierProvider\Core\Exceptions\Manager as ExceptionManager;

class Manager extends ExceptionManager
{
    protected $codes = [
        401 => UnauthorizedException::class,
    ];

    protected $code_keys = ['httpCode'];
}
