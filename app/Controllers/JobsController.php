<?php
namespace app\Controllers;

use app\Models\Job;
class JobsController extends BaseController{
  public function getAddJobAction()
  {
    echo $this->renderHtml('addJob.twig');
  }
  public function postAddJobAction($request)
  {
    
    if(empty($request->getMethod() == 'POST')){
      $data = $request->getParseBody();
      $job->title = $data["Title"];
      $job->description = $data["Description"];
      $job->save();
    }
    include '../views/addJob.php';
  }
}