<?php

namespace App\Exceptions;

class NoRoutesFoundsEception extends \Exception
{
    protected $message = "Not found route in the app";
    protected $code = 500;
}