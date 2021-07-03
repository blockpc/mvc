<?php

namespace App\Core;

use App\Exceptions\NoRoutesFoundsEception;
use App\Exceptions\NotFoundException;
use App\Exceptions\RouteNameExistsException;

/**
 * class Router
 */
class Router
{
    protected array $routes = [];
    protected array $names = [];
    protected array $params = [];
    protected Request $request;
    protected Response $response;
    protected string $method;
    protected string $path;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback)
    {
        $this->method = 'get';
        $this->path = $path;
        $this->routes[$this->method][$this->path] = $callback;
        return $this;
    }

    public function post(string $path, $callback)
    {
        $this->method = 'post';
        $this->path = $path;
        $this->routes[$this->method][$this->path] = $callback;
        return $this;
    }

    public function put(string $path, $callback)
    {
        $this->method = 'put';
        $this->path = $path;
        $this->routes[$this->method][$this->path] = $callback;
        return $this;
    }

    public function delete(string $path, $callback)
    {
        $this->method = 'delete';
        $this->path = $path;
        $this->routes[$this->method][$this->path] = $callback;
        return $this;
    }

    public function name(string $name)
    {
        if ( in_array($name, $this->names) ) {
            throw new RouteNameExistsException();
        }
        $this->names[$name] = $this->path;
    }

    public function route(string $name, string $param = "")
    {
        return $this->names[$name];
    }

    public function resolve()
    {
        try {
            if ( !count($this->routes) ) {
                throw new NoRoutesFoundsEception();
            }
            $method = $this->request->method;
            $routes = array_keys($this->routes[$method]);
            $callback = false;
            $param_route = [];
            foreach ( $routes as $route ) {
                $is_match = $this->patternMatches($route, $this->request->path, $param, PREG_OFFSET_CAPTURE);
                if ( $is_match ) {
                    preg_match('/\/{(.*?)}/', $route, $model, PREG_OFFSET_CAPTURE);
                    if ( $model ) {
                        $parametro = $param[1][0][0];
                        if ( $model[1][0] ) {
                            $name = "\\App\Models\\".ucfirst($model[1][0]);
                            $modelo = new $name;
                            if (!$param_route = $modelo->where($modelo->getRouteKeyName(), $parametro)->first() ) {
                                throw new RouteNameExistsException("Modelo {$name} no existe para {$parametro}");
                            }
                        }
                    }
                    $callback = $this->routes[$method][$route];
                    break;
                }
            }
            if ( !$callback ) {
                throw new NotFoundException();
            }
            if ( is_string($callback) ) {
                return $this->render($callback);
            }
            if ( is_array($callback) ) {
                app()->controller = new $callback[0]();
                $controller = app()->controller;
                $controller->action = $callback[1];
                $callback[0] = $controller;
            }
            if ( $param_route ) {
                return call_user_func($callback, $param_route, $this->request);
            }
            return call_user_func($callback, $this->request);
        } catch(\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            $this->render("errors._error", ['message' => $e->getMessage()]);
            exit;
        }
    }

    public function render(string $view, array $params = [])
    {
        $params = ['url' => app()->request->url] + $params;
        Template::view($view, $params);
    }
    
    /**
    * Replace all curly braces matches {} into word patterns (like Laravel)
    * Checks if there is a routing match
    *
    * @param $pattern
    * @param $uri
    * @param $matches
    * @param $flags
    *
    * @return bool -> is match yes/no
    */
    private function patternMatches($pattern, $uri, &$matches, $flags)
    {
        // Replace all curly braces matches {} into word patterns (like Laravel)
        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);

        // we may have a match!
        return boolval(preg_match_all('#^' . $pattern . '$#', $uri, $matches, PREG_OFFSET_CAPTURE));
    }
}