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

if (! function_exists('session') ) {
    function session(string $key, $value) {
        Session::set($key, $value);
        return true;
    }
}

if (! function_exists('flash') ) {
    function flash(string $key) {
        return Session::get($key);
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
        return $_POST[$key] ?? $value;
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

if (! function_exists('has_error') ) {
    function has_error(string $error = "") {
        return $error ? 'is-invalid' : '';
    }
}

if (! function_exists('text_error') ) {
    function text_error(string $error = "") {
        return $error ? "<div class='text-error'>{$error}</div>" : '';
    }
}

if (! function_exists('ip') ) {
    function ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}