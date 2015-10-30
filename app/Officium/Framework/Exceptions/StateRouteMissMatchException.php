<?php

namespace Officium\Framework\Exceptions;


class StateRouteMissMatchException extends \RuntimeException
{
    function __construct($uri, $expectedUri)
    {
        $message = "Invalid state route: (" . $uri . "). The current state route is: (" . $expectedUri .").";
        $code = 404;
        parent::__construct($message, $code);
    }

}