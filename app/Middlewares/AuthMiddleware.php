<?php
namespace App\Middlewares;

use App\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public $actions;

    public function __construct($actions)
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if ( !auth() ) {
            // if ( empty($this->actions) || in_array(app()->controller->action, $this->actions) ) {
            //     throw new ForbiddenException();
            // }
            throw new ForbiddenException();
        }
    }
}