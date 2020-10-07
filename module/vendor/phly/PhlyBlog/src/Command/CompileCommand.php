<?php

namespace PhlyBlog\Command;

use Laminas\Console\ColorInterface as Color;
use Laminas\View\View;
use PhlyBlog\Compiler;
use PhlyBlog\CompilerOptions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompileCommand extends Command
{
    public $config = [];
    public $view;

    protected $compiler;
    protected $compilerOptions;
    protected $console;
    protected $responseFile;
    protected $writer;


    protected $defaultOptions = [
        'all'     => true,
        'entries' => false,
        'archive' => false,
        'year'    => false,
        'month'   => false,
        'day'     => false,
        'tag'     => false,
        'author'  => false,
    ];


    protected function configure(): void
    {
        $this->setName('phly:blog:compile');
        $this->setDescription('PhlyBlog');
        $this->setHelp('Phly Static Blog Generator');

//-------------------------------------------------------------------------------------------------------------------------------------------------------
//PhlyBlog
//-------------------------------------------------------------------------------------------------------------------------------------------------------
        $this->addOption('all', 'a', InputOption::VALUE_OPTIONAL, 'Execute all actions (default)',true);
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
        $flags     = $this->getFlags($input);
        $compiler  = $this->getCompiler();
        $tags      = $this->attachTags();
        $listeners = $this->attachListeners($flags, $tags);

        // Compile
        $width = $this->console->getWidth();
        $this->console->write("Compiling and sorting entries", Color::BLUE);
        $compiler->compile();
        $this->reportDone($width, 29);

        // Create tag cloud
        if (
            $this->config['cloud_callback']
            && is_callable($this->config['cloud_callback'])
        ) {
            $callable = $this->config['cloud_callback'];
            $this->console->write("Creating and rendering tag cloud", Color::BLUE);
            $cloud = $tags->getTagCloud();
            call_user_func($callable, $cloud, $this->view, $this->config, $this->getServiceLocator());
            $this->reportDone($width, 32);
        }

        // compile various artifacts
        foreach ($listeners as $type => $listener) {
            $message = "Compiling " . $type;
            $this->console->write($message, Color::BLUE);
            $listener->compile();
            $this->reportDone($width, strlen($message));
        }
        return Command::SUCCESS;
    }


    public function getFlags(InputInterface  $input)
    {
        $options = $input->getOptions();
        $test = [
            ['long' => 'all',     'short' => 'a'],
            ['long' => 'entries', 'short' => 'e'],
            ['long' => 'archive', 'short' => 'c'],
            ['long' => 'year',    'short' => 'y'],
            ['long' => 'month',   'short' => 'm'],
            ['long' => 'day',     'short' => 'd'],
            ['long' => 'tag',     'short' => 't'],
            ['long' => 'author',  'short' => 'r'],
        ];
        foreach ($test as $spec) {
            $long  = $spec['long'];
            $short = $spec['short'];
            if (
                (! isset($options[$long]) || ! $options[$long])
                && (isset($options[$short]) && $options[$short])
            ) {
                $options[$long] = true;
                unset($options[$short]);
            }
        }

        $options = array_merge($this->defaultOptions, $options);
        if (
            $options['entries']
            || $options['archive']
            || $options['year']
            || $options['month']
            || $options['day']
            || $options['tag']
            || $options['author']
        ) {
            $options['all'] = false;
        }

        return $options;
    }

    public function getCompiler()
    {
        if ($this->compiler) {
            return $this->compiler;
        }

        $view             = $this->getView();
        $writer           = $this->getWriter();
        $config           = $this->config;
        $responseFile     = $this->getResponseFile();
        $responseStrategy = new Compiler\ResponseStrategy($writer, $responseFile, $view);
        $postFiles        = new Compiler\PhpFileFilter($config['posts_path']);

        $this->compiler   = new Compiler($postFiles);
        return $this->compiler;
    }
    public function getWriter()
    {
        if ($this->writer) {
            return $this->writer;
        }
        $this->writer = new Compiler\FileWriter();
        return $this->writer;
    }
    public function getResponseFile()
    {
        if ($this->responseFile) {
            return $this->responseFile;
        }
        $this->responseFile = new Compiler\ResponseFile();
        return $this->responseFile;
    }

    public function getView()
    {
        if ($this->view) {
            return $this->view;
        }
        $this->view = new View();
        return $this->view;
    }
    public function setView(View $view)
    {
        $this->view = $view;
    }
    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    public function attachTags()
    {
        $tags = new Compiler\Listener\Tags($this->view, $this->getWriter(), $this->getResponseFile(), $this->getCompilerOptions());
        $this->getCompiler()->getEventManager()->attach($tags);
        return $tags;
    }

    public function getCompilerOptions()
    {
        if ($this->compilerOptions) {
            return $this->compilerOptions;
        }

        $this->compilerOptions = new CompilerOptions($this->config['options']);
        return $this->compilerOptions;
    }


}
