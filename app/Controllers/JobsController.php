<?php
namespace app\Controllers;

use app\Models\Job;
use Respect\Validation\Validator as v;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class JobsController extends BaseController{
  public function getAddJobAction()
  {
    return $this->renderHtml('addJob.twig');
  }

  public function indexAction(){
    $jobs = Job::all();
    return $this->renderHtml('jobs/index.twig', compact('jobs'));
  }

  public function deleteAction(ServerRequest $request){
    $params = $request->getQueryParams();
    $job = Job::where('idjobs',$params['idjobs']);
    $job->delete();
    return new RedirectResponse('/platzi/jobs/');
  }
  public function postAddJobAction($request)
  {
    $responseMessage=null;
    if($request->getMethod() == 'POST'){
      $data = $request->getParsedBody();
      $jobValidator = v::key('Title', v::stringType()->notEmpty())
                  ->key('Description', v::stringType()->notEmpty());
      try{
        $jobValidator->assert($data);
        $files = $request->getUploadedFiles();
        $logo = $files["logo"];
        $ubicacionImagen="";
        if($logo->getError() == UPLOAD_ERR_OK){
          $fileName = $logo->getClientFileName();
          $ubicacionImagen="uploads/$fileName";
          $logo->moveTo($ubicacionImagen);
        }

        $job = new Job();
        $job->title = $data["Title"];
        $job->description = $data["Description"];
        $job->imange = $ubicacionImagen;
        $job->save();
        $responseMessage="Saved";
      }catch(\Exception $e ){
        $responseMessage= $e->getMessage();
      }
    }
    return $this->renderHtml('addJob.twig',[
      'responseMessage'=>$responseMessage
    ]);
  }


}