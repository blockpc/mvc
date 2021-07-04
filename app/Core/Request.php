<?php

namespace App\Core;

/**
 * class Request
 */
class Request
{
    public $url;
    public $body;
    public string $path;
    public string $method;

    public function __construct()
    {
        $this->url = URL_BASE;
        $this->body = [];
        $this->path = $this->path();
        $this->method = $this->method();
    }

    public function path()
    {
        $path = $_SERVER["REQUEST_URI"] ?? '/';
        try {
            if (!PRODUCTION && HTTP_HOST == "localhost") {
                $path = str_replace(LOCAL_XAMPP, '', $path);
                $this->url .= LOCAL_XAMPP;
            }
            $position = strpos($path, '?');
            if ( $position === false ) {
                return $path;
            }
            return substr($path, 0, $position);
        } catch(\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function method()
    {
        $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
        return strtolower($method);
    }

    public function json()
    {
        header("Content-type: application/json; charset=utf-8");
        return json_decode(file_get_contents("php://input"), true);
    }

    public function body()
    {
        try {
            $this->body = [];
            if ( $this->method === "get" ) {
                foreach( $_GET as $key => $value ) {
                    $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
                }
            }
            if ( $this->method === "post" || $this->method === "put" || $this->method === "delete") {
                if ( !isset($_POST['token']) ) {
                    session('error', 'Token form not exists.');
                    return false;
                }
                if ( !Session::token($_POST['token']) ) {
                    return false;
                }
                unset($_POST['token'], $_POST['_method']);
                foreach( $_POST as $key => $value ) {
                    $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
                }
            }
            return $this->body;
        } catch(\Exception $e) {
            app()->response->setStatusCode($e->getCode());
            $this->render("errors._error", [
                'codigo_error' => $e->getCode(),
                'message_error' => $e->getMessage(),
            ]);
            exit;
        }
    }

    private function render(string $view, array $params = [])
    {
        $params = ['url' => app()->request->url] + $params;
        Template::view($view, $params);
    }
}