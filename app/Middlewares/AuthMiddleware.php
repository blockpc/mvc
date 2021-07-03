<?php
namespace App\Middlewares;

use App\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct()
    {}

    public function execute()
    {
        if ( !auth() ) {
            // $controller = app()->controller;
            // if ( empty($this->actions) || in_array($controller->action, $this->actions) ) {
            //     throw new ForbiddenException();
            // }
            throw new ForbiddenException();
        }
    }
}