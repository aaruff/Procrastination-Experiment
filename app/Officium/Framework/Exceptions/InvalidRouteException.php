<?php

namespace Officium\Framework\Exceptions;


class InvalidRouteException extends \RuntimeException
{
    function __construct($uri)
    {
        $message = "Invalid route requested (" . $uri . ")";
        $code = 404;
        parent::__construct($message, $code);
    }

}