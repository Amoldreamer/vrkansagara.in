<?php

declare(strict_types=1);

namespace Blog\Delegators;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use PhlyBlog\Compiler\Event;
use PhlyBlog\EntryEntity;

class PhlyCompilerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $serviceName, callable $factory, array $options = null)
    {

        $compiler = $factory();
        $eventManager = $compiler->getEventManager();
        $eventManager->attach('compile', function (Event $event) {

            /** @var $entry EntryEntity */
            $entry = $event->getEntry();
            $date = $event->getDate();

            // Id and title must be same for URL
            $id = strtolower($entry->getId());
            $title = strtolower($entry->getTitle());

            $tmp = str_replace('-', ' ', substr($id, strlen($date)));
            if ($tmp != $title) {
                sprintf('%s is not matching, Please correct it.', $id);
                exit;
            }
        });
        return $compiler;
    }
}
