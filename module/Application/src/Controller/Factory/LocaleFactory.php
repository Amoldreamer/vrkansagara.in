<?php

namespace Application\Controller\Factory;

use Application\Controller\LocaleController;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\Container;

class LocaleFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        // The $container variable is the service manager.
        $sessionContainer = $container->get('ApplicationSessionContainer');

        $translator = $container->get('MvcTranslator');

        return new LocaleController($translator, $sessionContainer);
    }
}
