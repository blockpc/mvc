<?php
namespace App\Core;

use App\Middlewares\BaseMiddleware;

class Controller
{
    public string $action = '';
    protected BaseMiddleware $baseMiddleware;

    public function __construct()
    {
        $this->baseMiddleware = new BaseMiddleware();
    }

    protected function render(string $view, array $params = [])
    {
        $params = ['url' => app()->request->url] + $params;
        Template::view($view, $params);
    }

    public function middleware(string $middleware, $actions = null)
    {
        try {
            $class = $this->baseMiddleware->setActions($middleware, $actions);
            $class->execute();
        } catch(\Exception $e) {
            app()->response->setStatusCode($e->getCode());
            $this->render("errors._error", [
                'codigo_error' => $e->getCode(),
                'message_error' => $e->getMessage(),
            ]);
            exit;
        }
    }
}