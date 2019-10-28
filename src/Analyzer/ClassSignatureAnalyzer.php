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
     * @return array|\Exception|\ReflectionException
     */
    public function analyze()
    {
        try {
            $this->reflection = new \ReflectionClass($this->fullClassName);

            return $this->getClassInfo();
        } catch (\ReflectionException $e) {
            return $e;
        }
    }

    /**
     * Get class info[class_name, class_type, properties[], methods[]].
     *
     * @return array
     */
    private function getClassInfo(): array
    {
        return [
            'class_name' => $this->getClassName(),
            'class_type' => $this->getClassType(),
            'properties' => $this->getCount($this->getClassProperties()),
            'methods' => $this->getCount($this->getClassMethods()),
        ];
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClassName(): string
    {
        return $this->reflection->getShortName();
    }

    /**
     * Get class type: Default, Final or Abstract.
     *
     * @return string
     */
    public function getClassType(): string
    {
        if ($this->reflection->isAbstract()) {
            $type = self::CLASS_TYPE_ABSTRACT;
        } elseif ($this->reflection->isFinal()) {
            $type = self::CLASS_TYPE_FINAL;
        } else {
            $type = self::CLASS_TYPE_DEFAULT;
        }

        return $type;
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
