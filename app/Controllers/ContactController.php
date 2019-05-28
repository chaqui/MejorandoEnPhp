<?php
namespace app\Controllers;

use Zend\Diactoros\ServerRequest;

class ContactController extends BaseController
{
  public function index(){
    return $this->renderHtml('contacts/index.twig');
  }

  public function send(ServerRequest $request){
    var_dump($request->getParsedBody());
  }
}