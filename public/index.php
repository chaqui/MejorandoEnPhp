<?php
  ini_set('display_errors', '1');
  ini_set('display_startup_error', '1');
  error_reporting(E_ALL);

  require_once'../vendor/autoload.php';

  session_start();
  use Illuminate\Database\Capsule\Manager as Capsule;
  use Aura\Router\RouterContainer;
  use Zend\Diactoros\Response\RedirectResponse;
  use WoohooLabs\Harmony\Harmony;
  use Zend\Diactoros\Response;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
$capsule = new Capsule;
  $container = new DI\Container();
  $capsule->addConnection([
      'driver'    => 'mysql',
      'host'      => 'localhost',
      'database'  => 'curso_php',
      'username'  => 'root',
      'password'  => 'root',
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => '',
  ]);

  // Make this Capsule instance available globally via static methods... (optional)
  $capsule->setAsGlobal();

  // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
  $capsule->bootEloquent();

  $request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
  );
  $routerContainer = new RouterContainer();
  $map = $routerContainer->getMap();
  //determinación de la ruta
    $map->get('index','/platzi/',[
      'app\Controllers\IndexController',
      'indexAction']);

    $map->get('indexJobs','/platzi/jobs/',[
      'app\Controllers\JobsController',
      'indexAction']);

     $map->get('deleteJobs','/platzi/jobs/delete',[
      'app\Controllers\JobsController',
      'deleteAction']);
    $map->get('addJobs','/platzi/jobs/add',[
      'app\Controllers\JobsController',
      'getAddJobAction',
      'auth'=>true]);
    $map->post('saveJobs','/platzi/jobs/add',[
      'app\Controllers\JobsController',
      'postAddJobAction',
      'auth'=>true]);

    $map->get('addUsers','/platzi/users/add',[
        'app\Controllers\UsersController',
        'getAddUserAction',
        'auth'=>true]);
    $map->post('saveUsers','/platzi/users/add',[
      'app\Controllers\UsersController',
      'postAddUserAction',
      'auth'=>true]);

    $map->get('loginForm','/platzi/login',[
      'app\Controllers\AuthController',
      'getLogin']);
    $map->post('authLogin','/platzi/auth',[
        'app\Controllers\AuthController',
        'postLogin']);

    $map->get('admin','/platzi/admin',[
      'app\Controllers\AdminController',
      'getIndex',
      'auth'=>true]);

    $map->get('logout','/platzi/logout',[
      'app\Controllers\AuthController',
      'getLogout',
      'auth'=>true]);
  $matcher = $routerContainer->getMatcher();
  $route = $matcher->match($request);
  if(!$route){
    echo "No route ";
  }
  else{
    $handlerData = $route->handler;
    $needsAuth = $handlerData['auth'] ?? false;

    $sessionUserID = $_SESSION['user_id'] ?? null;
    if($needsAuth && !$sessionUserID )
    {
      $response =  new RedirectResponse('/platzi/login');
    }
    $harmony = new Harmony($request, new Response());
    $harmony
    ->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
    ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
    ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'));
    $harmony();

  }
?>