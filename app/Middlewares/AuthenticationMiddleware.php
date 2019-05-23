<?php
namespace app\Middlewares;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmptyResponse;

class AuthenticationMiddleware implements MiddlewareInterface
{
  private $routes;

  /**
   * __construct
   *
   * @param  RouterContainer $router
   *
   * @return void
   */
  public function __construct( $router)
  {
    $this->routes = $router;  
  }

  /**
   * process
   *
   * @param  ServerRequestInterface $request
   * @param  RequestHandlerInterface $handler
   *
   * @return ResponseInterface
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {

    if($this->rutaAuntenticada($request)){
      $sessionUserId = $_SESSION['user_id']?? null;
      if(!$sessionUserId)
      {
         
          return new EmptyResponse(401);
      }

    }
    return $handler->handle($request);
  }

  /**
   * rutaAuntenticada
   *
   * @param  string $ruta
   *
   * @return booelan
   */
  private function rutaAuntenticada($request)
  {
    $matcher = $this->routes->getMatcher();
    $route = $matcher->match($request);
    $handlerData = $route->handler;
    $needsAuth = $handlerData['auth'] ?? false;
    if($needsAuth){
      return true;
    }
    return false;
  }
}