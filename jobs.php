<?php
  require_once'vendor/autoload.php';

  use app\Models\{Job, Project};
  $name ="Josué Fuentes";
  $limitmonths =35;



  $jobs = Job::all();
  $projects = Project::all();