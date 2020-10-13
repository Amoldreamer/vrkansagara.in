<?php

declare(strict_types=1);

namespace Application\Controller\Plugin;

// Plugin class
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class AccessPlugin extends AbstractPlugin
{
    // This method checks whether user is allowed
    // to visit the page
    public function checkAccess($actionName)
    {
        return true;
    }
}
