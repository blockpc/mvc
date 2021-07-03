<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

require __DIR__.'/../config/config.php';
require __DIR__.'/../config/bootstrap.php';

use App\Controllers\PagesController;
use App\Core\{ Session, Application };

Session::init();
$app = new Application(dirname(__DIR__));

$app->router->get('/', [PagesController::class, 'home'])->name('home');

$app->run();