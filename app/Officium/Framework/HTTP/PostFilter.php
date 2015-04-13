<?php

namespace Officium\Framework\HTTP;


class PostFilter
{
    public static function filterEntries($post, $keyFilters)
    {
        $filtered = [];
        foreach ($keyFilters as $key) {
            $filtered[$key] = (isset($post[$key])) ? trim($post[$key]) : '';
        }

        return $filtered;
    }

}