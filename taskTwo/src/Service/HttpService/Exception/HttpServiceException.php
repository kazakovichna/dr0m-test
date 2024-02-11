<?php

namespace taskTwo\src\Service\HttpService\Exception;

use Exception;

class HttpServiceException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}