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

use Greeflas\StaticAnalyzer\Analyzer\ClassAuthorAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
final class ClassAuthorStatCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('stat:class-author')
            ->setDescription('Shows quantity of classes/interfaces/traits created by some developer')
            ->addArgument(
                'src',
                InputArgument::REQUIRED,
                'Absolute path to the source code'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'Developer\'s e-mail address'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $src = $input->getArgument('src');
        $email = $input->getArgument('email');

        $analyzer = new ClassAuthorAnalyzer($src, $email);
        $quantity = $analyzer->analyze();

        $output->writeln(\sprintf(
            '%d classes/interfaces/traits was created by developer with email %s',
            $quantity,
            $email
        ));
    }
}
