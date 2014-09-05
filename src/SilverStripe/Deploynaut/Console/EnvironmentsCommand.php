<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnvironmentsCommand extends Command {
	
	protected function configure() {
		$this->setName('envs')
			->setDescription('Return a list of environment names for the given project, 1 per line.')
			->setDefinition(array(
				new InputArgument('project', InputArgument::REQUIRED,
					'The project to list environments for'),


				new InputOption('server', 's', InputOption::VALUE_REQUIRED,
					'The deploynaut server URL'),
				new InputOption('auth', 'a', InputOption::VALUE_REQUIRED,
					'username:password'),
				new InputOption('conf', 'c', InputOption::VALUE_REQUIRED,
					'Set the configuration file (defaults to ~/.naut)'),
			));
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$naut = new NautAPIClient($input->getOptions());
		$args = $input->getArguments();

		foreach($naut->environments($args['project']) as $project) {
			$output->writeln($project);
		}
	}
}
