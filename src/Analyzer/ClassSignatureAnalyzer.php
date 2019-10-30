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

namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\ResultClassInfo;

/**
 * This is analyzer of classes.
 *
 * @author Vadim Selyan <vadimselyan@gmail.com>
 */
final class ClassSignatureAnalyzer
{
    public const CLASS_TYPE_ABSTRACT = 'Abstract';
    public const CLASS_TYPE_DEFAULT = 'Default';
    public const CLASS_TYPE_FINAL = 'Final';

    /**
     * @var string
     */
    private $fullClassName;
    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * ClassSignatureAnalyzer constructor.
     *
     * @param string $fullClassName
     */
    public function __construct(string $fullClassName)
    {
        $this->fullClassName = $fullClassName;
    }

    /**
     * Analyze class.
     *
     * @return ResultClassInfo
     *
     * @throws \ClassNotFoundReflectionException
     */
    public function analyze()
    {
        try {
            $this->reflection = new \ReflectionClass($this->fullClassName);

            return $this->getClassInfo();
        } catch (\ReflectionException $e) {
            throw \ClassNotFoundReflectionException::forClassUnavailable($this->fullClassName);
        }
    }

    /**
     * Create new ResultClassInfo and set properties.
     *
     * @return ResultClassInfo
     */
    private function getClassInfo(): ResultClassInfo
    {
        $count_properties = $this->getCount($this->getClassProperties());
        $count_methods = $this->getCount($this->getClassMethods());

        $result = new ResultClassInfo();
        $result->setClassName($this->getClassName());
        $result->setClassType($this->getClassType());
        $result->setCountProperties($count_properties['public'], $count_properties['protected'], $count_properties['private']);
        $result->setCountMethods($count_methods['public'], $count_methods['protected'], $count_methods['private']);

        return $result;
    }

    /**
     * Get class name.
     *
     * @return string
     */
    private function getClassName(): string
    {
        return $this->reflection->getShortName();
    }

    /**
     * Get class type: Default, Final or Abstract.
     *
     * @return string
     */
    private function getClassType(): string
    {
        if ($this->reflection->isAbstract()) {
            return self::CLASS_TYPE_ABSTRACT;
        }

        if ($this->reflection->isFinal()) {
            return self::CLASS_TYPE_FINAL;
        }

        return self::CLASS_TYPE_DEFAULT;
    }

    /**
     * Get all properties of class.
     *
     * @return \ReflectionProperty[]
     */
    private function getClassProperties(): array
    {
        return $this->reflection->getProperties();
    }

    /**
     * Get all methods of class.
     *
     * @return array
     */
    private function getClassMethods(): array
    {
        return $this->reflection->getMethods();
    }

    /**
     * Get count properties or methods.
     *
     * @param array $array
     *
     * @return array
     */
    private function getCount(array $array): array
    {
        $publicCount = 0;
        $protectedCount = 0;
        $privateCount = 0;

        foreach ($array as $el) {
            if ($el->isPublic()) {
                ++$publicCount;
            } elseif ($el->isPrivate()) {
                ++$protectedCount;
            } elseif ($el->isProtected()) {
                ++$privateCount;
            }
        }

        return [
            'public' => $publicCount,
            'protected' => $protectedCount,
            'private' => $privateCount,
        ];
    }
}
