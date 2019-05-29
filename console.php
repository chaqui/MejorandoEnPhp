<#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


use Symfony\Component\Console\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

/**
 * containter para realizar las inserciones de objetos a constructores
 */
  $container = new DI\Container();

/**
 * configuracion de base de datos
 */
  $capsule->addConnection([
      'driver'    => getenv("DB_DRIVER"),
      'host'      => getenv("DB_HOST"),
      'database'  => getenv("DB_NAME"),
      'username'  => getenv("DB_USER"),
      'password'  => getenv("DB_PSWD"),
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => '',
  ]);

  // Make this Capsule instance available globally via static methods... (optional)
  $capsule->setAsGlobal();

  // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
  $capsule->bootEloquent();
$application = new Application();

$application->add(new app\Commands\HelloWorldCommand());
$application->add(new app\Commands\SendMailCommand());

$application->run();