<?php


  require_once'../vendor/autoload.php';

  session_start();

  //OBjeto para usar variables de entorno almacenadas en .env
  $dotenv = Dotenv\Dotenv::create(__DIR__.'/..');
  $dotenv->load();
//si esta en modo debug mostrar los errores de PHP
if(getenv("DEBUG")==='true')
{
  ini_set('display_errors', '1');
  ini_set('display_startups_error', '1');
  error_reporting(E_ALL);
}

  use Illuminate\Database\Capsule\Manager as Capsule;
  use Aura\Router\RouterContainer;
  use Zend\Diactoros\Response\RedirectResponse;
  use WoohooLabs\Harmony\Harmony;
  use Zend\Diactoros\Response;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use app\Middlewares\AuthenticationMiddleware;
use Aura\Router\Exception;
use Franzl\Middleware\Whoops\WhoopsMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Log de eventos para la app
 */
$log = new Logger('app');
//incluyendo su handler
$log->pushHandler(new StreamHandler(__DIR__.'/../logs/app.log', Logger::WARNING));

/**
 * encapulador de Base de Datos 
 */
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

  /**
   * request de solicitudes
   */
  $request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
  );

  /**
   * creacion del contenedor de rutas
   */
  $routerContainer = new RouterContainer();
  /**
   * creación del mapa de rutas 
   */
  $map = $routerContainer->getMap();
  /**
   * mapeo para la determinación de la ruta
   */
    $map->get('index','/platzi/',[
      'app\Controllers\IndexController',
      'indexAction']);

    $map->get('indexJobs','/platzi/jobs/',[
      'app\Controllers\JobsController',
      'indexAction',
      'auth'=>true]);

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
  //determinacion de match de ruta 
  $matcher = $routerContainer->getMatcher();
  $route = $matcher->match($request);
  if(!$route){
    echo "No route ";
  }
  else{
        try
        {
          /**
           * harmony: constructor de respuesta
           */
          $harmony = new Harmony($request, new Response());
          /**
           * agregando los middlewares de la respuesta (cebollita)
           */
          $harmony
          /**
           * Emisor de respuesta
           */
          ->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()));
          /**
           * capturador de excepciones y muestra de errores ( si esta en DEBUG)
           */
          if(getenv('DEBUG')=== 'true')
          {
            $harmony->addMiddleware(new WhoopsMiddleware() );
          }
          //
          /**
           * verificacion de autenticacion
           */
          $harmony->addMiddleware(new AuthenticationMiddleware($routerContainer))
          /**
           * selector de ruta
           */
          ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
          /**
           * despachador de controladores con el respoectivo cointener (insercion de objetos en los constructores)
           */
          ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'));
          /**
           * ejecucion del harmony
           */
          $harmony();
        }
          catch (Exception $e){
            /**
             * enviar error al log
             */
          
            $log->warning($e->getMessage());
            $emmiter = new SapiEmitter();
            $emmiter->emit(new Response\EmptyResponse(400));
          }
        /**
         *  si exciste un error emitir el error
         */
        catch(Error $e)
        {
          $emmiter = new SapiEmitter();
          $emmiter->emit(new Response\EmptyResponse(500));
        }
  }
?>