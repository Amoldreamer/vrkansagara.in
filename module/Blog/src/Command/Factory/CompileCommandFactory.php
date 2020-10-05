<?php


namespace Blog\Command\Factory;


use Blog\Command\CompileCommand;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class CompileCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new CompileCommand();

        return $controller;
    }
}