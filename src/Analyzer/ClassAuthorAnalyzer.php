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

use Greeflas\StaticAnalyzer\Util\PhpFileHelper;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\Finder\Finder;

/**
 * This is analyzer of classes, interfaces and traits that counts...
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
final class ClassAuthorAnalyzer
{
    private $src;
    private $email;

    public function __construct(string $src, string $email)
    {
        $this->src = $src;
        $this->email = $email;
    }

    public function analyze(): int
    {
        /* @var \Symfony\Component\Finder\SplFileInfo[] $finder */
        $finder = Finder::create()
            ->in($this->src)
            ->files()
            ->name('/^[A-Z].+\.php$/')
        ;

        $counter = 0;

        $docBlockFactory = DocBlockFactory::createInstance();

        foreach ($finder as $file) {
            $namespace = PhpFileHelper::getClassNameFromFile($file->getPathname());

            try {
                $reflector = new \ReflectionClass($namespace);
            } catch (\ReflectionException $e) {
                continue;
            }

            $docComment = $reflector->getDocComment();

            if (!$docComment) {
                continue;
            }

            $docBlock = $docBlockFactory->create($docComment);

            /* @var \phpDocumentor\Reflection\DocBlock\Tags\Author[] $authors */
            $authors = $docBlock->getTagsByName('author');

            foreach ($authors as $author) {
                if ($author->getEmail() === $this->email) {
                    ++$counter;

                    break;
                }
            }
        }

        return $counter;
    }
}
