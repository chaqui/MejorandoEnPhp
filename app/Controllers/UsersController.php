<?php
namespace app\Controllers;

use app\Models\User;
use Respect\Validation\Validator as v;
class UsersController extends BaseController{
  public function getAddUserAction()
  {
    return $this->renderHtml('addUser.twig');
  }
  public function postAddUserAction($request)
  {
    $responseMessage=null;
    if($request->getMethod() == 'POST'){
      $data = $request->getParsedBody();
      $userValidator = v::key('correo', v::stringType()->notEmpty())
                  ->key('contrasenia', v::stringType()->notEmpty());
      try{
        $userValidator->assert($data);
        $user = new User();
        $user->mail = $data["correo"];

        $pass = $data['contrasenia'];
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $user->password = $passHash;
        $user->save();
        $responseMessage="Saved";
      }catch(\Exception $e ){
        $responseMessage= $e->getMessage();
      }
    }
    return $this->renderHtml('addUser.twig',[
      'responseMessage'=>$responseMessage
    ]);
  }
}