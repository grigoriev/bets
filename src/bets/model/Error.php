<?php

namespace bets\model;

use Exception;

class Error extends AbstractObject
{
    public $code;
    public $message;
    public $stacktrace;

    public function __construct(Exception $exception)
    {
        $this->code = $exception->getCode();
        $this->message = $exception->getMessage();
        $this->stacktrace = $exception->getTraceAsString();
    }
}