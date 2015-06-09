<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\TaskController;

class TaskMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/task.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/task';
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