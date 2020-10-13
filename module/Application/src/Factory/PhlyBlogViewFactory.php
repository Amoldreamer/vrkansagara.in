<?php

namespace Application\Factory;

use Laminas\Http\PhpEnvironment\Request;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\View;
use Psr\Container\ContainerInterface;
use Laminas\Router\Http\TreeRouteStack;
use Laminas\View\Helper\Url;

class PhlyBlogViewFactory
{
    public function __invoke(ContainerInterface $container): View
    {
        $renderer = $this->createRenderer($container);
        $view     = new View();
        $view->setEventManager($container->get('EventManager'));
        $view->setRequest(new Request());
        $view->setResponse(new Response());
        $view->addRenderingStrategy(
            function () use ($renderer) {
                return $renderer;
            },
            100
        );

        $layout = new ViewModel();
        $layout->setTemplate('layout');
        $view->addResponseStrategy(function ($e) use ($layout, $renderer) {
            $result = $e->getResult();
            $layout->setVariable('content', $result);
            $page = $renderer->render($layout);
            $e->setResult($page);
        }, 100);


        return $view;
    }

    private function createRenderer(ContainerInterface $container): PhpRenderer
    {
        /** @var \Laminas\View\HelperPluginManager $helpers */
        $helpers   = $container->get('ViewHelperManager');
        $renderer  = new PhpRenderer();
        $urlHelper = (new Url())->setRouter($container->get(TreeRouteStack::class));
        $helpers->setService('url', $urlHelper);

        $renderer->setHelperPluginManager($helpers);
        $renderer->setResolver($container->get('ViewResolver'));

        $config = $container->get('config');
        $layout = $config['view_manager']['layout'] ?? 'layout/layout';
        $model  = $this->getRootModel($container);
        $model->setTemplate($layout);
        $helpers->get('view_model')->setRoot($model);

        return $renderer;
    }
    private function getRootModel(ContainerInterface $container): ViewModel
    {
        if (! $container->has('MvcEvent')) {
            return new ViewModel();
        }

        $event = $container->get('MvcEvent');
        return $event->getViewModel();
    }
}