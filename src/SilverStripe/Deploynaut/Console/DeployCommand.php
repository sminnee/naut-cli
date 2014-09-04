<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends Command {
	
	protected function configure() {
		$this->setName('deploy')
			->setDescription('Deploy the given SHA to the given project on the given environment.')
			->setDefinition(array(
				new InputArgument('project:environment', InputArgument::REQUIRED,
					'The project and environment to deploy to'),
				new InputArgument('sha', InputArgument::REQUIRED,
					'The SHA to deploy'),
			));
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('to do');
	}
}
