<?php

use Illuminate\Container\Container;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;

$app = new Container();
Facade::setFacadeApplication($app);

$app->singleton('hash', function () use ($app) {
    return new HashManager($app);
});

class_alias(Hash::class, 'Hash');