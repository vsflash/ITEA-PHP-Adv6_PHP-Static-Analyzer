<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 10/29/19
 * Time: 5:51 PM
 */

namespace Greeflas\StaticAnalyzer;


class ResultClassInfo
{
    private $class_name;
    private $class_type;

    private $count_public_properties;
    private $count_protected_properties;
    private $count_private_properties;

    private $count_public_methods;
    private $count_protected_methods;
    private $count_private_methods;

    public function setClassName(string $class_name): void
    {
        $this->class_name = $class_name;
    }

    public function setClassType(string $class_type): void
    {
        $this->class_type = $class_type;
    }

    public function setCountProperties(int $count_public_properties, int $count_protected_properties, int $count_private_properties): void
    {
        $this->count_public_properties = $count_public_properties;
        $this->count_protected_properties = $count_protected_properties;
        $this->count_private_properties = $count_private_properties;
    }

    public function setCountMethods(int $count_public_methods, int $count_protected_methods, int $count_private_methods): void
    {
        $this->count_public_methods = $count_public_methods;
        $this->count_protected_methods = $count_protected_methods;
        $this->count_private_methods = $count_private_methods;
    }
}