<?php

declare(strict_types=1);

namespace Blog\Delegators;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class PhlyCompilerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $factory, array $options = null)
    {

        $compiler = $factory();
        $eventManager = $compiler->getEventManager();
        $eventManager->attach('PhlyBlog\Compiler', function () {
            echo 'Here......';
        });
        return $compiler;
    }
}
