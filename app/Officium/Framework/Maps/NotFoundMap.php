<?php

namespace Officium\Framework\Maps;


class NotFoundMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/404.twig';
    }

}