<?php

use App\Core\{ Session, Application };
use Illuminate\Container\Container;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;

$container = new Container();
Facade::setFacadeApplication($container);

Session::init();
$app = $container->make(Application::class);

// $container->singleton('hash', function () use ($container) {
//     return new HashManager($container);
// });

// $hash = $container->make('hash');

// $container->singleton('Hash', function () use ($container) {
//     return new Hash($container);
// });


// class_alias(Hash::class, 'Hash');