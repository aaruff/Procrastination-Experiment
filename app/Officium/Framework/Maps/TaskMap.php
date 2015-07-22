<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\TaskController;

class TaskMap extends ResourceMap
{
    public static $CONDITIONS = ['id'=>'[1-3]'];
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/task.twig';
    }

    /**
     * @param string $id
     * @return string
     */
    public static function toUri($id = ':id')
    {
        return "/task/$id";
    }

    /**
     * @param $uri
     * @return bool
     */
    public static function isUri($uri)
    {
        return $uri === self::toUri('1') || $uri === self::toUri('2') || $uri === self::toUri('3');
    }

    public static function getTaskNumber($uri)
    {
        $parts = explode('/', $uri);
        return intval($parts[2]);
    }

    /**
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new TaskController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }
}