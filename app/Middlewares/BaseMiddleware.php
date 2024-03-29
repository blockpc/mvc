<?php
namespace App\Middlewares;

class BaseMiddleware
{
    public array $middlewares = [];

    public function __construct()
    {
        $this->middlewares = [
            'auth' => AuthMiddleware::class,
            'profile' => ProfileMiddleware::class,
        ];
    }

    public function getMiddleware(string $middleware)
    {
        return new $this->middlewares[$middleware]();
    }

    public function setActions(string $middleware, $actions)
    {
        $class = new $this->middlewares[$middleware]($actions);
        return $class;
    }
}