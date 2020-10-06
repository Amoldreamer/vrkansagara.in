<?php

namespace PhlyBlog\Command;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\View;
use PhlyBlog\CompileController;

class CompileCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $services   = $container;
        $config     = $services->get('Config');
        $config     = isset($config['blog']) ? $config['blog'] : [];

        $request    = $services->get('Request');
        $response   = $services->get('Response');
        $view       = new View();
        $view->setRequest($request);
        $view->setResponse($response);

        $controller = new CompileController();
        $controller->setConfig($config);
//        $controller->setConsole($services->get('Console'));
        $controller->setView($view);
        return $controller;
    }
}
