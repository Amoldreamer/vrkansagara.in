<?php

declare(strict_types=1);

namespace Application\Delegators;

use Interop\Container\ContainerInterface;
use Laminas\EventManager\Event;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

class PhlyCompilerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $factory, array $options = null)
    {

        $compiler = $factory();
        $eventManager = $compiler->getEventManager();
        $eventManager->attach('PhlyBlog\Compiler', function () {
            echo '<pre>'; var_dump('Here......'); echo __FILE__; echo __LINE__; exit(0);
        });
        return $compiler;
    }
}
