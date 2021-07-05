<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

require __DIR__.'/../config/config.php';
require __DIR__.'/../config/bootstrap.php';

use App\Controllers\System\SystemController;
use App\Controllers\Auth\AuthController;
use App\Controllers\PagesController;
use App\Controllers\System\UserController;
use App\Core\{ Session, Application };

Session::init();
$app = new Application();
$app->router->get('/error', [SystemController::class, 'error'])->name('error');

$app->router->get('/responsive', [PagesController::class, 'responsive'])->name('responsive');

$app->router->get('/', [PagesController::class, 'home'])->name('home');
$app->router->get('/login', [AuthController::class, 'login'])->name('auth.login');
$app->router->post('/login', [AuthController::class, 'login'])->name('auth.login.post');
$app->router->post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
$app->router->get('/register', [AuthController::class, 'register'])->name('auth.register');
$app->router->post('/register', [AuthController::class, 'register'])->name('auth.register.post');

$app->router->get('/sistema/dashboard', [SystemController::class, 'dashboard'])->name('dashboard');
$app->router->get('/sistema/configuracion', [SystemController::class, 'settings'])->name('settings');

$app->router->get('/user/{user}', [UserController::class, 'profile'])->name('profile');

$app->run();