<?php
namespace app\Controllers;
use app\Models\{Job,Project};

class IndexController extends BaseController{
  public function indexAction(){
    $name ="Josué Fuentes";
    $limitmonths =35;
    $jobs = Job::all();
    $projects = Project::all();

    return $this->renderHTML('index.twig',[
      'name'=>$name,
      'jobs'=>$jobs,
      'projects'=>$projects
      ]);
  }
}