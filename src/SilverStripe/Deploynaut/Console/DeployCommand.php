<?php

namespace SilverStripe\Deploynaut\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends Command {

    protected function configure() {
        $this->setName('deploy')
            ->setDescription('Deploy the given SHA to the given project on the given environment')
            ->setDefinition(array(
                new InputArgument('project', InputArgument::REQUIRED,
                    'The project to deploy'),
                new InputArgument('environment', InputArgument::REQUIRED,
                    'The environment to deploy to'),
                new InputArgument('sha', InputArgument::REQUIRED,
                    'The SHA to deploy'),

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

        // Deploy deployment
        $output->writeln("Deploying {$args['sha']} to {$args['environment']} on {$args['project']}...");
        $status = $naut->deploy($args['project'], $args['environment'], $args['sha']);


        $output->write("Queued");

        $alreadyPrinted = null;
        while(true) {
            $data = $status->getStatus();
            if($data['status'] == 'Queued') {
                $output->write(".");

            } else {
                if($alreadyPrinted === null) {
                    $output->writeln("");
                    $alreadyPrinted = "";
                }

                $newMessage = substr($data['message'], strlen($alreadyPrinted));
                $output->write($newMessage);

                $alreadyPrinted = $data['message'];

            }

            if($data['status'] == 'Failed' || $data['status'] == 'Invalid') throw new \LogicException("Deployment failed");
            if($data['status'] == 'Complete') break;
        }

        $output->writeln("Finished!");
    }
}
