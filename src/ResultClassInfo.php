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

namespace Greeflas\StaticAnalyzer;

/**
 * @author Vadim Selyan <vadimselyan@gmail.com>
 */
final class ResultClassInfo
{
    private $class_name;
    private $class_type;

    private $count_public_properties;
    private $count_protected_properties;
    private $count_private_properties;

    private $count_public_methods;
    private $count_protected_methods;
    private $count_private_methods;

    /**
     * @param string $class_name
     */
    public function setClassName(string $class_name): void
    {
        $this->class_name = $class_name;
    }

    /**
     * @param string $class_type
     */
    public function setClassType(string $class_type): void
    {
        $this->class_type = $class_type;
    }

    /**
     * @param int $count_public_properties
     * @param int $count_protected_properties
     * @param int $count_private_properties
     */
    public function setCountProperties(int $count_public_properties, int $count_protected_properties, int $count_private_properties): void
    {
        $this->count_public_properties = $count_public_properties;
        $this->count_protected_properties = $count_protected_properties;
        $this->count_private_properties = $count_private_properties;
    }

    /**
     * @param int $count_public_methods
     * @param int $count_protected_methods
     * @param int $count_private_methods
     */
    public function setCountMethods(int $count_public_methods, int $count_protected_methods, int $count_private_methods): void
    {
        $this->count_public_methods = $count_public_methods;
        $this->count_protected_methods = $count_protected_methods;
        $this->count_private_methods = $count_private_methods;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * @return mixed
     */
    public function getClassType()
    {
        return $this->class_type;
    }

    /**
     * @return mixed
     */
    public function getCountPublicProperties()
    {
        return $this->count_public_properties;
    }

    /**
     * @return mixed
     */
    public function getCountProtectedProperties()
    {
        return $this->count_protected_properties;
    }

    /**
     * @return mixed
     */
    public function getCountPrivateProperties()
    {
        return $this->count_private_properties;
    }

    /**
     * @return mixed
     */
    public function getCountPublicMethods()
    {
        return $this->count_public_methods;
    }

    /**
     * @return mixed
     */
    public function getCountProtectedMethods()
    {
        return $this->count_protected_methods;
    }

    /**
     * @return mixed
     */
    public function getCountPrivateMethods()
    {
        return $this->count_private_methods;
    }
}
