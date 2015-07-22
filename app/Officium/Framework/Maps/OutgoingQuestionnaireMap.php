<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\OutgoingQuestionnaireController;

class OutgoingQuestionnaireMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/outgoing.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/out';
    }

    /**
     * @param $uri
     * @return bool
     */
    public static function isUri($uri)
    {
        return $uri === self::toUri();
    }

    /**
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new OutgoingQuestionnaireController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }
}