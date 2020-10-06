<?php

namespace PhlyBlog;

use Laminas\View\Model;
use Laminas\View\Renderer\PhpRenderer;

class Module
{
    public static $config;

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return ['factories' => [
            'blogrenderer' => function ($services) {
                $helpers  = $services->get('ViewHelperManager');
                $resolver = $services->get('ViewResolver');

                $renderer = new PhpRenderer();
                $renderer->setHelperPluginManager($helpers);
                $renderer->setResolver($resolver);

                $config = $services->get('Config');
                if ($services->has('MvcEvent')) {
                    $event  = $services->get('MvcEvent');
                    $model  = $event->getViewModel();
                } else {
                    $model = new Model\ViewModel();
                }
                $layout = 'layout/layout';
                if (isset($config['view_manager']['layout'])) {
                    $layout = $config['view_manager']['layout'];
                }
                $model->setTemplate($layout);
                $helpers->get('view_model')->setRoot($model);

                return $renderer;
            },
        ]];
    }


    public function onBootstrap($e)
    {
        $app          = $e->getApplication();
        $services     = $app->getServiceManager();
        self::$config = $services->get('config');
    }

    public static function prepareCompilerView($view, $config, $services)
    {
        $renderer = $services->get('BlogRenderer');
        $view->addRenderingStrategy(function ($e) use ($renderer) {
            return $renderer;
        }, 100);
    }
}
