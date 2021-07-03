<?php

namespace App\Core;

class Response
{
    public function setStatusCode($code)
    {
        $code = is_string($code) ? 1 : $code;
        http_response_code($code);
    }

    public function redirect(string $url = '/', int $code = 302)
    {
        header('Location: '.$url, TRUE, $code);
        exit;
    }
}