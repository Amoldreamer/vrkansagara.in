<?php

namespace PhlyBlog\Command;

use Laminas\InputFilter\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('phly:blog:compile');
        $this->setDescription('PhlyBlog');
        $this->setHelp('Phly Static Blog Generator');

//-------------------------------------------------------------------------------------------------------------------------------------------------------
//PhlyBlog
//-------------------------------------------------------------------------------------------------------------------------------------------------------
        $this->addOption('all', 'a', InputOption::VALUE_OPTIONAL, 'Execute all actions (default)');
        $this->addOption('entries', 'e', InputOption::VALUE_OPTIONAL, 'Compile entries');
        $this->addOption('archive', 'c', InputOption::VALUE_OPTIONAL, 'Compile paginated archive (and feed)');
        $this->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by year');
        $this->addOption('month', 'm', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by month');
        $this->addOption('day', 'd', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by day');
        $this->addOption('tag', 't', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by tag (and feeds)');
        $this->addOption('author', 'r', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by author (and feeds)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $page = $input->getOption('page');
        if (! $page) {
            return $this->clearAllPages($output);
        }

        return Command::SUCCESS;
    }
}
