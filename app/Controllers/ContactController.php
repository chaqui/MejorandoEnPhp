<?php
namespace app\Controllers;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class ContactController extends BaseController
{
  public function index(){
    return $this->renderHtml('contacts/index.twig');
  }

  public function send(ServerRequest $request){
    $requestData = $request->getParsedBody();
    // Create the Transport
    $transport = (new \Swift_SmtpTransport(getenv("SMTP_HOST"), getenv('SMTP_PORT')))
    ->setUsername(getenv('SMTP_USER'))
    ->setPassword(getenv('SMTP_PASS'));

    // Create the Mailer using your created Transport
    $mailer = new \Swift_Mailer($transport);

    // Create a message
    $message = (new \Swift_Message('Wonderful Subject'))
    ->setFrom(['contact@mail.com' => 'John Doe'])
    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
    ->setBody('Hi, you have a message. Name: '.$requestData["Name"]." Email:".$requestData["Email"]. ' Message: '.$requestData["Message"]);

    // Send the message
    $result = $mailer->send($message);
    return new RedirectResponse('/platzi/');

  }
}