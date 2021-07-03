<?php
namespace App\Exceptions;

class RouteNameExistsException extends \Exception
{
    protected $code = 500;
    protected $message = "The route name exists";
}