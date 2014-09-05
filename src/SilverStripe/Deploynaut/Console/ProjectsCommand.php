<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\HttpFoundation;

class ProjectsCommand extends Command {
	
	protected function configure() {
		$this->setName('projects')
			->setDescription('Return a list of project names, 1 per line')
			->setDefinition(array(			
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

		foreach($naut->projects() as $project) {
			$output->writeln($project);
		}
	}
}
