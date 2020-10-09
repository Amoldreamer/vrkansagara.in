<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Mvc\Plugin\Prg',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\ZendFrameworkBridge',
    'Laminas\Db',
    'Laminas\ZendFrameworkBridge',
    'Laminas\I18n',
    'Laminas\Session',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\InputFilter',
    'Laminas\Filter',
    'Laminas\Mail',
    'Laminas\Cache',
    'Laminas\Router',
    'Laminas\Validator',
    'Laminas\DeveloperTools',


    'ZfcUser',
//    'BjyAuthorize',
//    'ZfcRbac',
//    'BjyProfiler',

    'Album',
    'Crawler',
    'PhlyContact',
    'PhlyBlog',
    'PhlySimplePage',
    'Application',
];
