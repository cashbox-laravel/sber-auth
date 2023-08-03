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

namespace Cashbox\Sber\Auth\Exceptions;

use Cashbox\Core\Exceptions\Http\UnauthorizedException;
use Cashbox\Core\Exceptions\Manager as ExceptionManager;

class Manager extends ExceptionManager
{
    protected $codes = [
        401 => UnauthorizedException::class,
    ];

    protected $code_keys = ['httpCode'];
}
