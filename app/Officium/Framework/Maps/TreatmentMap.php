<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\TreatmentController;

class TreatmentMap extends ResourceMap
{
    /**
     * @param $id string URI Parameter ID
     * @return string
     */
    public static function toUri($id = '')
    {
        $uri = '/experiment/treatment';
        if ($id == self::$ID) {
            return $uri . '/:id';
        }

        return $uri;
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new TreatmentController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }

    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/experimenter/experiment/treatment/show.twig';
    }

    public static function isUri($path)
    {
        if ($path == self::toUri()) {
           return true;
        }
        else if (self::toUri() == implode('/', array_slice(explode('/', $path), 0, -1))) {
            return true;
        }

        return false;
    }

}