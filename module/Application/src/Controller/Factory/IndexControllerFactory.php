<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\View;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

//        $viewManager = $container->get('HttpViewManager');
//        $vieModel = $viewManager->getViewModel();
//        $vieModel->setVariable('test123',123131313123);
//
        return new IndexController();
    }
}
