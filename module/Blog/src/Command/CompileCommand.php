<?php
declare(strict_types=1);

namespace Blog\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{
    public $config = array();
    public $view;

    protected $compiler;
    protected $compilerOptions;
    protected $console;
    protected $responseFile;
    protected $writer;

    protected function configure(): void
    {

        $this->setName('blog:compile');
        $this->setDescription('Blog information module');
        $this->setHelp('This command will provide more details about how this command is working.');

//-------------------------------------------------------------------------------------------------------------------------------------------------------
//PhlyBlog
//-------------------------------------------------------------------------------------------------------------------------------------------------------

        // index.php blog compile [--all|-a] [--entries|-e] [--archive|-c] [--year|-y] [--month|-m] [--day|-d] [--tag|-t] [--author|-r]    Compile blog:
        $this->addOption('all', 'a', InputOption::VALUE_OPTIONAL, 'Execute all actions (default)');
        $this->addOption('entries', 'e', InputOption::VALUE_OPTIONAL, 'Compile entries');
        $this->addOption('archive', 'c', InputOption::VALUE_OPTIONAL, 'Compile paginated archive (and feed)');
        $this->addOption('year', 'y', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by year');
        $this->addOption('month', 'm', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by month');
        $this->addOption('day', 'd', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by day');
        $this->addOption('tag', 't', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by tag (and feeds)');
        $this->addOption('author', 'r', InputOption::VALUE_OPTIONAL, 'Compile paginated entries by author (and feeds)');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return Command::SUCCESS;
    }
}