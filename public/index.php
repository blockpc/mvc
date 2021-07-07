<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

require __DIR__.'/../config/config.php';
require __DIR__.'/../config/bootstrap.php';

use App\Controllers\Auth\AuthController;
use App\Controllers\PagesController;
use App\Controllers\System\{SystemController, UsersController, RolesController, PermissionsController};
use App\Core\{ Session, Application };

Session::init();
$app = new Application();
$app->router->get('/error', [SystemController::class, 'error'])->name('error');

$app->router->get('/', [PagesController::class, 'home'])->name('home');
$app->router->get('/login', [AuthController::class, 'login'])->name('auth.login');
$app->router->post('/login', [AuthController::class, 'login'])->name('auth.login.post');
$app->router->post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
$app->router->get('/register', [AuthController::class, 'register'])->name('auth.register');
$app->router->post('/register', [AuthController::class, 'register'])->name('auth.register.post');

$app->router->get('/sistema/dashboard', [SystemController::class, 'dashboard'])->name('dashboard');
$app->router->get('/sistema/configuracion', [SystemController::class, 'settings'])->name('settings');
$app->router->get('/sistema/perfil', [SystemController::class, 'profile'])->name('profile');

// $app->router->get('/sistema/usuarios', [UsersController::class, 'index'])->name('users.index');
// $app->router->get('/sistema/usuarios/nuevo', [UsersController::class, 'create'])->name('users.create');
// $app->router->post('/sistema/usuarios/nuevo', [UsersController::class, 'create'])->name('users.store');
// $app->router->get('/sistema/usuarios/editar/{user}', [UsersController::class, 'edit'])->name('users.edit');
// $app->router->put('/sistema/usuarios/editar/{user}', [UsersController::class, 'edit'])->name('users.update');
// $app->router->get('/sistema/usuarios/eliminar/{user}', [UsersController::class, 'delete'])->name('users.delete');
// $app->router->delete('/sistema/usuarios/eliminar/{user}', [UsersController::class, 'delete'])->name('users.detroy');
$app->router->resource('/sistema/usuarios', UsersController::class, 'user', 'users');

$app->router->resource('/sistema/roles', RolesController::class, 'role', 'roles');

$app->router->get('/sistema/permisos', [PermissionsController::class, 'index'])->name('permissions.index');

$app->run();