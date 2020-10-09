<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Sendmail;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;

class IndexController extends AbstractActionController
{

    /**
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
    public function onDispatch(MvcEvent $e)
    {
        // Call the base class' onDispatch() first and grab the response
        $response = parent::onDispatch($e);

        // Set alternative layout
        $this->layout()->setTemplate('layout/layout');

        // Return the response
        return $response;
    }

    public function indexAction()
    {
        $inspire = [
            [
             'text' =>"Don't repeat yourself",
             'author' =>null
            ]
        ];
        $count = count($inspire) - 1;
        return new ViewModel([
            'inspire' => $inspire[rand(0,$count)]
        ]);
    }

    /**
     * @return ViewModel
     */
    public function searchAction()
    {
        return new ViewModel();
    }
}
