<?php

namespace Application\Factory;

use Laminas\View\View;
use Psr\Container\ContainerInterface;
use PhlyBlog\Console\CompileCommand;

class CompileCommandFactory
{
    /**
     * @param ContainerInterface $container
     * @return CompileCommand
     */
    public function __invoke(ContainerInterface $container): CompileCommand
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = $config['blog'] ?? [];

        return new CompileCommand(
            $config,
            $container,
            $container->get(View::class)
        );
    }
}
