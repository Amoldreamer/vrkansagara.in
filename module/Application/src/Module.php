<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Config\Config;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Helper as ViewHelper;
use Laminas\View\Model\ViewModel;
use Laminas\View\HelperPluginManager;
use Laminas\Console\Console;

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
//    public function init(ModuleManager $manager)
//    {
//        // Get event manager.
////        $eventManager = $manager->getEventManager();
//
////        $sharedEventManager = $eventManager->getSharedManager();
////        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', [$this, 'onDispatch'], 100);
//    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_FINISH, function ($e) {
            $time = microtime(true) - REQUEST_MICROTIME;

            // formatting time to be more friendly
            if ($time <= 60) {
                $timeF = number_format($time, 2, ',', '.') . 's'; // conversion to seconds
            } else {
                $resto = fmod($time, 60);
                $minuto = number_format($time / 60, 0);
                $timeF = sprintf('%dm%02ds', $minuto, $resto); // conversion to minutes and seconds
            }

            // Search static content and replace for execution time
            $response = $e->getResponse();
            $content = $this->compressJscript($response->getContent());
//            $content = self::compress($content);
            $response->setContent(str_replace(
                'Execution time:',
                'Execution time: ' . $timeF,
                $content
            ));
        }, 100000);
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
        $buffer = preg_replace(
            array_keys($allRules),
            array_values($allRules),
            $buffer
        );

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
     * @note Code will be healed even after marked as @deprecated for further reference.
     * @param $buffer
     *
     * @return null|string|string[] Compressed output
     * @deprecated
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
        $new_buffer = preg_replace($regexRemoveWhiteSpace, '', $buffer);
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

    public function compressJscript($buffer)
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
                function ($instance, $services) {
                    if (! Console::isConsole()) {
                        return;
                    }
                    if (! $instance instanceof HelperPluginManager) {
                        return;
                    }
                    $instance->setFactory('basePath', function ($sm) use ($services) {
                        $config = $services->get('Config');
                        $config = $config['view_manager'];
                        $basePathHelper = new ViewHelper\BasePath();
                        $basePath = '/';
                        if (isset($config['base_path'])) {
                            $basePath = $config['base_path'];
                        }
                        $basePathHelper->setBasePath($basePath);
                        return $basePathHelper;
                    });
                },
            ]];
    }

    public static function prepareCompilerView($view, $config, $services)
    {
        $renderer = $services->get('BlogRenderer');
        $view->addRenderingStrategy(function ($e) use ($renderer) {
            return $renderer;
        }, 100);

        $layout = new ViewModel();
        $layout->setTemplate('layout');
        $view->addResponseStrategy(function ($e) use ($layout, $renderer) {
            $result = $e->getResult();
            $layout->setVariable('content', $result);
            $page = $renderer->render($layout);
            $e->setResult($page);

            // Cleanup
            $layout->setVariable('single', false);

            $headTitle = $renderer->plugin('headtitle');
            $headTitle->getContainer()->exchangeArray([]);
            $headTitle->append('VRKANSAGARA');
            $headTitle->setSeparator(' - ');
            $headTitle->setAutoEscape(false);

            $headLink = $renderer->plugin('headLink');
            $headLink->getContainer()->exchangeArray([]);
            $headLink([
                'rel' => 'shortcut icon',
                'type' => 'image/vnd.microsoft.icon',
                'href' => '/images/Application/favicon.ico',
            ]);

            $headScript = $renderer->plugin('headScript');
            $headScript->getContainer()->exchangeArray([]);

            $headMeta = $renderer->plugin('headMeta');
            $headMeta->getContainer()->exchangeArray([]);

            foreach (['sidebar', 'scripts'] as $name) {
                $placeholder = $renderer->placeholder($name);
                $placeholder->exchangeArray([]);
            }
        }, 100);
    }

    public static function handleTagCloud($cloud, $view, $config)
    {
        if (! self::$layout) {
            return;
        }

        self::$layout->setVariable('footer', sprintf(
            "<h4>Tag Cloud</h4>\n<div class=\"cloud\">\n%s</div>\n",
            $cloud->render()
        ));
    }
}
