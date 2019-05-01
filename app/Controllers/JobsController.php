<?php
namespace App\Controllers;

use app\Models\Job;
class JobsController{
  public function getAddJobAction()
  {
    include '../views/addJob.php';
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