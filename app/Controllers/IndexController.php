<?php
namespace app\Controllers;
use app\Models\{Job,Project};

class IndexController extends BaseController{
  public function indexAction(){
    $name ="Josué Fuentes";
    $limitmonths =35;
    $jobs = Job::all();
    $projects = Project::all();

    echo $this->renderHTML('index.twig',[
      'name'=>$name,
      'jobs'=>$jobs
      ]);
  }
}