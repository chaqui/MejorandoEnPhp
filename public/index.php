<?php
  ini_set('display_errors', '1');
  ini_set('display_startup_error', '1');
  error_reporting(E_ALL);

  require_once'../vendor/autoload.php';
  use Illuminate\Database\Capsule\Manager as Capsule;
  use Aura\Router\RouterContainer;

  function printElement( $job){
    // if(!$job->getVisible()){
    //   return;
    // }
    echo '<li class="work-position">';
    echo " <h5>".$job->title."</h5>";
    echo " <p>".$job->description ."</p>";
    echo " <p>".$job->getDurationAsString() ."</p>";
    echo '<strong>Achievements:</strong>';
    echo ' <ul>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
    echo '</ul>';
    echo '</li>';
  }

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

  $map->get('addJobs','/platzi/jobs/add',[
    'controller'=>'app\Controllers\JobsController',
    'action'=>'getAddJobAction']);
    $map->post('saveJobs','/platzi/jobs/add',[
      'controller'=>'app\Controllers\JobsController',
      'action'=>'postAddJobAction']);

  $matcher = $routerContainer->getMatcher();
  $route = $matcher->match($request);
  if(!$route){
    echo "No route ";
  }
  else{
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $controller= new $controllerName;
    $response = $controller-> $actionName($request);

    echo $response->getBody();
  }
?>