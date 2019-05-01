<?php
namespace App\Controllers;
use app\Models\{Job,Project};

class IndexController{
  public function indexAction(){
    $name ="Josué Fuentes";
    $limitmonths =35;
    $jobs = Job::all();
    $projects = Project::all();

    include '../views/index.php';
  }
}