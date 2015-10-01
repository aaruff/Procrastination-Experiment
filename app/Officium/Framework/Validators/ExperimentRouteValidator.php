<?php

namespace Officium\Framework\Validators;


class ExperimentRouteValidator
{
    /**
     * Returns true if the route is an experiment route (non resource).
     *
     * @param $uri
     * @return bool
     */
    public static function isExperimentRoute($uri)
    {
        if (is_null($uri) || ! is_string($uri)) {
            return false;
        }

        $splitUri = explode('/', $uri);
        if ( ! is_array($splitUri) || empty($splitUri) || count($splitUri) < 2) {
            return false;
        }

        $base = $splitUri[1];
        if ($base === 'session') {
            return true;
        }

        return false;
    }
}