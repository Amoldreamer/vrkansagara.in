<?php

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\ConverterInterface;

if (! function_exists('env')) {
    function env($key, $default = null)
    {
        return ($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }
}

if (! function_exists('is_production_mode')) {

    /**
     *Display all errors when APPLICATION_ENV is development.
     * @return bool
     */
    function is_production_mode(): bool
    {
        $isProductionModeEnable = in_array(env('APP_ENV'), ['prod', 'production', 'staging']);
        if ($isProductionModeEnable) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            ini_set('display_errors', '0');
            ini_set("display_startup_errors", '0');
            ini_set("log_errors", '1');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            ini_set("display_startup_errors", '1');
            ini_set("log_errors", '1');
        }
        return $isProductionModeEnable;
    }
}

if (! function_exists('getRequestExecutionTime')) {

    /**
     * @param $startMicroTime
     * @param $endMicroTime
     * @param null $format @todo Add feature here.
     * @return string
     */
    function getRequestExecutionTime($startMicroTime, $endMicroTime, $format = null): string
    {
        $time = $startMicroTime - $endMicroTime;

        // formatting time to be more friendly
        if ($time <= 60) {
            $timeF = number_format($time, 2, ',', '.') . 's'; // conversion to seconds
        } else {
            $resto = fmod($time, 60);
            $minuto = number_format($time / 60, 0);
            $timeF = sprintf('%dm%02ds', $minuto, $resto); // conversion to minutes and seconds
        }

        return $timeF;
    }
}

if (! function_exists('convertMarkdownToHtml')) {
    /**
     * Convert Markdown text into html
     * @param $markdownContent
     * @param array $options Markdown option for CommonMarkConverter object.
     * @return string Converted HTML string
     */
    function convertMarkdownToHtml($markdownContent, array $options = [])
    {
        $converter = new CommonMarkConverter([
            'html_input' => isset($options['html_input']) ? $options['html_input'] : 'strip',
            'allow_unsafe_links' => isset($options['allow_unsafe_links']) ? $options['allow_unsafe_links'] : false,
        ]);
        return $converter->convertToHtml($markdownContent);
    }
}
