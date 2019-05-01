<?php
namespace app\Controllers;

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
    return $this->templateEngine->render($fileName,$data);
  }
}

