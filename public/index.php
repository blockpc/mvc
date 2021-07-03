<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

require __DIR__.'/../config/config.php';
require __DIR__.'/../config/bootstrap.php';

use App\Controllers\Auth\AuthController;
use App\Controllers\PagesController;
use App\Core\{ Session, Application };

Session::init();
$app = new Application(dirname(__DIR__));

$app->router->get('/', [PagesController::class, 'home'])->name('home');
$app->router->get('/login', [AuthController::class, 'login'])->name('auth.login');
$app->router->get('/register', [AuthController::class, 'register'])->name('auth.register');

$app->run();