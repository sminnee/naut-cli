<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class EnvironmentsCommand extends Command {
	
	protected function configure() {
		$this->setName('envs')
			->setDescription('Return a list of environment names for the given project, 1 per line.')
			->setDefinition(array(
				new InputArgument('project', InputArgument::REQUIRED,
					'The project to list environments for'),
			));
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('to do');
	}
}
