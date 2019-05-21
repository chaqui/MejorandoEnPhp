<?php
  ini_set('display_errors', '1');
  ini_set('display_startup_error', '1');
  error_reporting(E_ALL);

  require_once'../vendor/autoload.php';

  session_start();
  use Illuminate\Database\Capsule\Manager as Capsule;
  use Aura\Router\RouterContainer;
  use Zend\Diactoros\Response\RedirectResponse;

  $capsule = new Capsule;

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
      'controller'=>'app\Controllers\IndexController',
      'action'=>'indexAction']);

    $map->get('indexJobs','/platzi/jobs/',[
      'controller'=>'app\Controllers\JobsController',
      'action'=>'indexAction']);

     $map->get('deleteJobs','/platzi/jobs/delete',[
      'controller'=>'app\Controllers\JobsController',
      'action'=>'deleteAction']);
    $map->get('addJobs','/platzi/jobs/add',[
      'controller'=>'app\Controllers\JobsController',
      'action'=>'getAddJobAction',
      'auth'=>true]);
    $map->post('saveJobs','/platzi/jobs/add',[
      'controller'=>'app\Controllers\JobsController',
      'action'=>'postAddJobAction',
      'auth'=>true]);

    $map->get('addUsers','/platzi/users/add',[
        'controller'=>'app\Controllers\UsersController',
        'action'=>'getAddUserAction',
        'auth'=>true]);
    $map->post('saveUsers','/platzi/users/add',[
      'controller'=>'app\Controllers\UsersController',
      'action'=>'postAddUserAction',
      'auth'=>true]);

    $map->get('loginForm','/platzi/login',[
      'controller'=>'app\Controllers\AuthController',
      'action'=>'getLogin']);
    $map->post('authLogin','/platzi/auth',[
        'controller'=>'app\Controllers\AuthController',
        'action'=>'postLogin']);

    $map->get('admin','/platzi/admin',[
      'controller'=>'app\Controllers\AdminController',
      'action'=>'getIndex',
      'auth'=>true]);
    
    $map->get('logout','/platzi/logout',[
      'controller'=>'app\Controllers\AuthController',
      'action'=>'getLogout',
      'auth'=>true]);
  $matcher = $routerContainer->getMatcher();
  $route = $matcher->match($request);
  if(!$route){
    echo "No route ";
  }
  else{
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false;

    $sessionUserID = $_SESSION['user_id'] ?? null;
    if($needsAuth && !$sessionUserID )
    {
      $response =  new RedirectResponse('/platzi/login');
    }
    else
    {
      $controller= new $controllerName;
      $response = $controller-> $actionName($request);
    }
    
    foreach($response->getHeaders() as $name =>$values){
      foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value),false);
      }
    }
    
    http_response_code($response->getStatusCode());
    echo $response->getBody();
  }
?>