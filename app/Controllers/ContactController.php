<?php
namespace app\Controllers;

use Zend\Diactoros\ServerRequest;
use app\Models\MessageModel;

class ContactController extends BaseController
{
  public function index(){
    return $this->renderHtml('contacts/index.twig');
  }

  public function send(ServerRequest $request){
    $requestData = $request->getParsedBody();
    $message = new MessageModel();
    $message->name =$requestData["Name"];
    $message->email = $requestData["Email"];
    $message->message = $requestData["Message"];
    $message->send = false;
    $message->save();

  }
}