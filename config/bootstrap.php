<?php

use Illuminate\Container\Container;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;

$container = new Container();
Facade::setFacadeApplication($container);

// $container->singleton('hash', function () use ($container) {
//     return new HashManager($container);
// });

// $container->singleton('Hash', function () use ($container) {
//     return new Hash($container);
// });


// class_alias(Hash::class, 'Hash');