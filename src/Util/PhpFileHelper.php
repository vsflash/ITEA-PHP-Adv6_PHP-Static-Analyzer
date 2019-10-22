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

namespace Greeflas\StaticAnalyzer\Util;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
final class PhpFileHelper
{
    public static function getClassNameFromFile(string $pathToFile): string
    {
        $contents = \file_get_contents($pathToFile);
        $namespace = $class = '';
        $gettingNamespace = $gettingClass = false;

        foreach (\token_get_all($contents) as $token) {
            $hasTokenInfo = \is_array($token);

            if ($hasTokenInfo && \T_NAMESPACE == $token[0]) {
                $gettingNamespace = true;
            } elseif ($hasTokenInfo && \T_CLASS == $token[0]) {
                $gettingClass = true;
            }

            if ($gettingNamespace) {
                if ($hasTokenInfo && \in_array($token[0], [\T_STRING, \T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } elseif (';' === $token) {
                    $gettingNamespace = false;
                }
            } elseif (true === $gettingClass) {
                if ($hasTokenInfo && \T_STRING == $token[0]) {
                    $class = $token[1];

                    break;
                }
            }
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }
}
