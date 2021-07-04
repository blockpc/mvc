<?php

namespace App\Core;

use App\Models\User;

/**
 * Class Application
 */
class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public static ?User $user;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $database;
    private $matches;

    public function __construct()
    {
        self::$ROOT_DIR = ROOT_APP;
        self::$app = $this;
        self::$user = Session::getUser();
        $this->response = new Response();
        $this->request = new Request();
        $this->database = new Database();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        try {
            $this->router->resolve();
        } catch(\Exception $e) {
            session('codigo_error', $e->getCode());
            session('message_error', $e->getMessage());
            redirect(route('error'));
        }
    }

    public function login(User $user, $recordarme)
    {
        self::$user = $user;
        $ip = ip();
        Session::iniciarSesion($user, $recordarme, $ip);
    }

    public function logout()
    {
        self::$user = null;
        Session::logout();
    }
}