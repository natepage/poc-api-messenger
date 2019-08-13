<?php
declare(strict_types=1);

namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('poc:hello-world');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello world');

        \sleep(80);
    }
}
