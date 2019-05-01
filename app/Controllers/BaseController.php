<?php
namespace app\Controllers;

use Zend\Diactoros\Response\HtmlResponse;
class BaseController
{
  protected $templateEngine;
  public function __construct(){

    $loader = new \Twig\Loader\FilesystemLoader('../views');
    $this->templateEngine  = new \Twig\Environment($loader, [
      'debug' =>true,
      'cache' => false,
  ]);
  }

  public function renderHtml($fileName, $data =[]){
    return new HtMlResponse( $this->templateEngine->render($fileName,$data));
  }

}

