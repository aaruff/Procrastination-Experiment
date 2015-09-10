<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\GameOverController;

class GameOverMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/game_over.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/experiment/over';
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
     * @return string
     */
    public static function toController()
    {
        $controller = get_class(new GameOverController());
        return $controller . ':get';
    }

}