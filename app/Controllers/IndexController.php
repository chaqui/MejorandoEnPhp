<?php
namespace app\Controllers;
use app\Models\{Job,Project};

class IndexController extends BaseController{
  public function indexAction(){
       $name ="Josué Fuentes";
    $limitmonths =0;
    $jobs = Job::all();
    $projects = Project::all();

    $jobs = $jobs->reject(function ($job) use($limitmonths){
      return $job->months < $limitmonths;
    });

    return $this->renderHTML('index.twig',[
      'name'=>$name,
      'jobs'=>$jobs,
      'projects'=>$projects
      ]);
  }
}