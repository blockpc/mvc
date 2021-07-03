<?php

namespace App\Exceptions;

class ForbiddenException extends \Exception
{
    protected $message = "You don't have permissions to access this page";
    protected $code = 403;
}