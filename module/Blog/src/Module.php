<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Blog;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public static function handleTagCloud($cloud, $config, $container)
    {
//        $model->setVariable('tagCloud', sprintf(
//            "<h4>Tag Cloud</h4>\n<div class=\"mt-5 ml-5\">\n%s</div>\n",
//            $cloud->render()
//        ));
    }

    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
