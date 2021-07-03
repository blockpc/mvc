<?php

use App\Core\Application;
use App\Core\Session;

if (! function_exists('app') ) {
    function app() {
        return Application::$app;
    }
}

if (! function_exists('auth') ) {
    function auth() {
        return Application::$app::$user;
    }
}

if (! function_exists('flash') ) {
    function flash(string $key) {
        return Session::getFlash($key);
    }
}

if (! function_exists('csrf_token') ) {
    function csrf_token() {
        $token = Session::setToken();
        echo "<input type='hidden' name='token' id='token' value='{$token}' />";
    }
}

if (! function_exists('method_field')) {
    function method_field($method) {
        echo "<input type='hidden' name='_method' value='{$method}' />";
    }
}

if (! function_exists('old') ) {
    function old(string $key, $value = null) {
        return Session::getBody($key) ?: $value;
    }
}

if (! function_exists('url') ) {
    function url(string $url = "") {
        $url = ltrim($url, '/');
        return URL_BASE . "/{$url}";
    }
}

if (! function_exists('route') ) {
    function route(string $name = "", string $params = "") {
        $url = app()->router->route($name, $params);
        if ( $params ) {
            $url = preg_replace('/\{(\w+)\}/', $params, $url);
        }
        return url($url);
    }
}

if (! function_exists('asset') ) {
    function asset(string $url = "") {
        $url = rtrim($url, '/');
        $asset = LOCAL_XAMPP ? URL_BASE . "/public" : URL_BASE;
        return "{$asset}/{$url}";
    }
}

if (! function_exists('redirect') ) {
    function redirect(string $url = "", int $code = 302) {
        app()->response->redirect($url, $code);
    }
}