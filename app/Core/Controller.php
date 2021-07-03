<?php
namespace App\Core;

use App\Middlewares\BaseMiddleware;

class Controller
{
    public string $layout = "main";
    public string $action = '';
    protected BaseMiddleware $baseMiddlware;

    public function __construct()
    {
        $this->baseMiddlware = new BaseMiddleware();
    }

    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    protected function render(string $view, array $params = [])
    {
        $params = ['url' => app()->request->url] + $params;
        Template::view($view, $params);
    }

    public function middleware(string $middlware)
    {
        try {
            $class = $this->baseMiddlware->getMiddleware($middlware);
            $class->execute();
        } catch(\Exception $e) {
            app()->response->setStatusCode($e->getCode());
            $this->render("errors._error", ['message' => $e->getMessage()]);
            exit;
        }
    }
}