<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Config\Config;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManager;
use Laminas\Http\Response as HttpResponse;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;

class Module implements
    ConfigProviderInterface,
    ServiceProviderInterface
{

    protected static $layout;
    protected $config;

    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    // The "init" method is called on application start-up and
    // allows to register an event listener.
    public function init(ModuleManager $manager)
    {
//         Get event manager.
//        $eventManager = $manager->getEventManager();
//        $sharedEventManager = $eventManager->getSharedManager();
//        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', [$this, 'onDispatch'], 100);

//        $this->sampleEvents($eventManager);
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();
        $services = $application->getServiceManager();

        $eventManager->attach(MvcEvent::EVENT_FINISH, function ($e) {
            $timeF = getRequestExecutionTime(microtime(true), REQUEST_MICROTIME);
            // Search static content and replace for execution time
            $response = $e->getResponse();
            $content = $response->getContent();
            $content = $this->compressJscript($content);
            $content = self::compress($content);
            $response->setContent(str_replace(
                'Execution time:',
                'Execution time: ' . $timeF,
                $content
            ));
        }, 100000);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'rotateXPoweredByHeader']);
//        $eventManager->attach(
//            MvcEvent::EVENT_ROUTE,
//            $services->get('Application\RedirectListener'),
//            -1
//        );
    }

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'disqus' => function ($serviceManager) {
                    $config = $serviceManager->get('config');
                    if ($config instanceof Config) {
                        $config = $config->toArray();
                    }
                    $config = $config['disqus'];
                    return new View\Helper\Disqus($config);
                },
            ]
        ];
    }

    // Event listener method.
    public function onDispatch(MvcEvent $event)
    {

        $whiteSpaceRules = [
            '/(\s)+/s' => '\\1',// shorten multiple whitespace sequences
            "#>\s+<#" => ">\n<",  // Strip excess whitespace using new line
            "#\n\s+<#" => "\n<",// strip excess whitespace using new line
            '/\>[^\S ]+/s' => '>',
            // Strip all whitespaces after tags, except space
            '/[^\S ]+\</s' => '<',// strip whitespaces before tags, except space
            /**
             * '/\s+     # Match one or more whitespace characters
             * (?!       # but only if it is impossible to match...
             * [^<>]*   # any characters except angle brackets
             * >        # followed by a closing bracket.
             * )         # End of lookahead
             * /x',
             */
            //            '/\s+(?![^<>]*>)/x' => '', //Remove all whitespaces except content between html tags. //MOST DANGEROUS
        ];
        $commentRules = [
            "/<!--.*?-->/ms" => '',// Remove all html comment.,
        ];
        $replaceWords = [
            //OldWord will be replaced by the NewWord
            //              '/\bOldWord\b/i' =>'NewWord' // OldWord <-> NewWord DO NOT REMOVE THIS LINE. {REFERENCE LINE}
        ];
        $allRules = array_merge(
            $replaceWords,
            $commentRules,
            $whiteSpaceRules
        );
        $buffer = $this->compressJscript($buffer);
        $buffer = preg_replace(array_keys($allRules), array_values($allRules), $buffer);

        // Get controller to which the HTTP request was dispatched.
//        $controller = $event->getTarget();
        // Get fully qualified class name of the controller.
//        $controllerClass = get_class($controller);
        // Get module name of the controller.
//        $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));

        // Switch layout only for controllers belonging to our module.
//        if ($moduleNamespace == __NAMESPACE__) {
//            $viewModel = $event->getViewModel();
//            $viewModel->setTemplate('layout/layout2');
//        }
    }

    /**
     * This method will no longer support.
     *
     * @param $buffer
     *
     * @return null|string|string[] Compressed output
     *
     */
    public static function compress($buffer)
    {
        /**
         * To remove useless whitespace from generated HTML, except for Javascript.
         * [Regex Source]
         * https://github.com/bcit-ci/codeigniter/wiki/compress-html-output
         * http://stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
         * %# Collapse ws everywhere but in blacklisted elements.
         * (?>             # Match all whitespaces other than single space.
         * [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
         * | \s{2,}        # or two or more consecutive-any-whitespace.
         * ) # Note: The remaining regex consumes no text at all...
         * (?=             # Ensure we are not in a blacklist tag.
         * (?:           # Begin (unnecessary) group.
         * (?:         # Zero or more of...
         * [^<]++    # Either one or more non-"<"
         * | <         # or a < starting a non-blacklist tag.
         * (?!/?(?:textarea|pre)\b)
         * )*+         # (This could be "unroll-the-loop"ified.)
         * )             # End (unnecessary) group.
         * (?:           # Begin alternation group.
         * <           # Either a blacklist start tag.
         * (?>textarea|pre)\b
         * | \z          # or end of file.
         * )             # End alternation group.
         * )  # If we made it here, we are not in a blacklist tag.
         * %ix
         */
        $regexRemoveWhiteSpace
            = '%(?>[^\S ]\s*| \s{2,})(?=(?:(?:[^<]++| <(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))%ix';
        $new_buffer = preg_replace($regexRemoveWhiteSpace, ' ', $buffer);
        // We are going to check if processing has working
        if ($new_buffer === null) {
            $new_buffer = $buffer;
        }

        return $new_buffer;
    }

    public function formatSizeUnits($size)
    {
        $base = log($size) / log(1024);
        $suffix = ['', 'KB', 'MB', 'GB', 'TB'];
        $f_base = floor($base);

        return round(pow(1024, $base - floor($base)), 2) . $suffix[$f_base];
    }

    public static function compressJscript($buffer): string
    {
        // JavaScript compressor by John Elliot <jj5@jj5.net>
        $replace = [
            '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'",
            // remove comments from ' strings
            '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"',
            // remove comments from " strings
            '#/\*.*?\*/#s' => "",// strip C style comments
            '#[\r\n]+#' => "\n",
            // remove blank lines and \r's
            '#\n([ \t]*//.*?\n)*#s' => "\n",
            // strip line comments (whole line only)
            '#([^\\])//([^\'"\n]*)\n#s' => "\\1\n",
            // strip line comments
            // (that aren't possibly in strings or regex's)
            '#\n\s+#' => "\n",// strip excess whitespace
            '#\s+\n#' => "\n",// strip excess whitespace
            '#(//[^\n]*\n)#s' => "\\1\n",
            // extra line feed after any comments left
            // (important given later replacements)
            '#/([\'"])\+\'\'\+([\'"])\*#' => "/*"
            // restore comments in strings
        ];
        $script = preg_replace(array_keys($replace), $replace, $buffer);
        $replace = [
            "&&\n" => "&&",
            "||\n" => "||",
            "(\n" => "(",
            ")\n" => ")",
            "[\n" => "[",
            "]\n" => "]",
            "+\n" => "+",
            ",\n" => ",",
            "?\n" => "?",
            ":\n" => ":",
            ";\n" => ";",
            "{\n" => "{",
            //  "}\n"  => "}", (because I forget to put semicolons after function assignments)
            "\n]" => "]",
            "\n)" => ")",
            "\n}" => "}",
            "\n\n" => "\n",
        ];
        $script = str_replace(array_keys($replace), $replace, $script);

        return trim($script);
    }

    public function getServiceConfig()
    {
        return [
            'initializers' => [
            ]];
    }


    public function rotateXPoweredByHeader(MvcEvent $e)
    {
        $response = $e->getResponse();
        if (! $response instanceof HttpResponse) {
            return;
        }

        static $xPoweredByHeaders = [
            'ASP.NET',
            'Django',
            'MVC.NET',
            'Play Framework',
            'Rails',
            'Spring',
            'Supreme Allied Commander',
            'Symfony2',
            'Zend Framework 2',
            'Laminas Framework',
        ];

        $value = $xPoweredByHeaders[rand(0, count($xPoweredByHeaders) - 1)];

        $response->getHeaders()
            ->addHeaderLine('X-Powered-By', $value);
    }

    public function sampleEvents(EventManager $eventManager)
    {
        $eventManager->attach('do', function (Event $event) {
            $eventName = $event->getName();
            $params = $event->getParams();
            $target = $event->getTarget();
            $isPropaagation = $event->propagationIsStopped();
            printf(
                'Handled event "%s", with parameters %s, And Targets is %s, propagation status %s',
                $eventName,
                json_encode($params),
                $target,
                $isPropaagation
            );
        });
        $params = ['foo' => 'bar', 'baz' => 'bat'];
        $eventManager->trigger('do', null, $params);
    }
}
