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

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassSignatureAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Vadim Selyan <vadimselyan@gmail.com>
 */
final class ClassSignatureStatCommand extends Command
{
    /**
     * Option rules.
     */
    protected function configure(): void
    {
        $this
            ->setName('stat:class-signature')
            ->setDescription('Shows class name/type, properties and methods count/type of some class')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Full class name'
            );
    }

    /**
     * Execute class.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $fullClassName = $input->getArgument('fullClassName');
        $analyzer = new ClassSignatureAnalyzer($fullClassName);
        $signatures = $analyzer->analyze();

        $output_string = $this->createOutput($signatures);
        $output->writeln($output_string);
    }

    /**
     * Create output string.
     *
     * @param array $array
     *
     * @return string
     */
    private function createOutput(array $array): string
    {
        $output = '';
        $output .= \sprintf('Class: %s is %s' . \PHP_EOL, $array['class_name'], $array['class_type']);

        $output .= \sprintf('Properties:' . \PHP_EOL);
        $output .= \sprintf("\tpublic: %d\n", $array['properties']['public'], );
        $output .= \sprintf("\tprotected: %d\n", $array['properties']['protected'], );
        $output .= \sprintf("\tprivate: %d\n", $array['properties']['private']);

        $output .= \sprintf('Methods:') . \PHP_EOL;
        $output .= \sprintf("\tpublic: %d\n", $array['methods']['public'], );
        $output .= \sprintf("\tprotected: %d\n", $array['properties']['protected']);
        $output .= \sprintf("\tprivate: %d\n", $array['properties']['private'], );

        return $output;
    }
}
