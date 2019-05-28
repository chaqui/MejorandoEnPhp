<?php

namespace app\Commands;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class HelloWorldCommand extends Command
{
  protected static $defaultName = 'app:Hello-world';

  public function configure()
  {
    $this->addArgument('neme',  InputArgument::REQUIRED , 'User Name');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
    {
       $output->writeln( "Hello ".$input->getArgument('neme'));
    }
}
