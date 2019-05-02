<?php
namespace app\Controllers;

use app\Models\User;
use Zend\Diactoros\Response\RedirectResponse;
class AuthController extends BaseController
{
    public function getlogin()
    {
      return $this->renderHtml('login.twig');
    }

    public function postLogin($request)
    {
      $postData = $request->getParsedBody();
      $responseMessage=null;
      $user = User::where('mail',$postData['correo'])->first();
      if($user)
      {
        if(password_verify($postData["contrasenia"], $user->password)){
          return new RedirectResponse('/platzi/admin');
        }
        else{
          $responseMessage= 'Bad Credentials';
        }
      }
      else
      {
        $responseMessage= 'Bad Credentials';

      }

      return $this->renderHtml('login.twig',[
        'responseMessage'=>$responseMessage
      ]);
    }
}
