<?php

namespace Blog\Compiler\Factory;


use Blog\Compiler\ResponseFile;
use Blog\Compiler\ResponseStrategy;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\View;

class ResponseStrategyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $writer = $container->get('FileWriter');
        $file = $container->get('ResponseFile');
        $view = new View();
        return new ResponseStrategy($writer, $file, $view);
    }

}