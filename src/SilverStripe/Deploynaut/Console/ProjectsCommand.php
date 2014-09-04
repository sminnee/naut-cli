<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectsCommand extends Command {
	
	protected function configure() {
		$this->setName('projects')
			->setDescription('Return a list of project names, 1 per line');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$output->writeln('to do');
	}
}
