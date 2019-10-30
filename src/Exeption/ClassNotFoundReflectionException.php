<?php

declare(strict_types=1);

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author Vadim Selyan <vadimselyan@gmail.com>
 */
final class ClassNotFoundReflectionException extends \ReflectionException
{
    public static function forClassUnavailable($fullClassName)
    {
        return new self('Class ' . $fullClassName . ' does not exist');
    }
}
