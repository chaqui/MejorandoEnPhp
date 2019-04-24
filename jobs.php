<?php
  require_once'vendor/autoload.php';

  use app\Models\{Job, Project, Printable};
  $name ="Josué Fuentes";
  $limitmonths =35;

  $job1 = new Job("PHP Developer",'Lenguaje cool');
  $job1->setMonths(6);

  $job2 = new Job("Python Developer",'El Mejor Lenguaje');
  $job2->setMonths(6);

  $job3 = new Job("",'El Mejor Lenguaje');
  $job3->setMonths(12);

  $project1 = new Project('Project 1', "Descripcion");
  $jobs = [
      $job1,
      $job2,
      $job3
    ];
  $projects = [
    $project1
  ];
    function printElement(Printable $job){
      if(!$job->getVisible()){
        return;
      }
      echo '<li class="work-position">';
      echo " <h5>".$job->getTitle()."</h5>";
      echo " <p>".$job->getDescription() ."</p>";
      echo " <p>".$job->getDurationAsString() ."</p>";
      echo '<strong>Achievements:</strong>';
      echo ' <ul>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '</ul>';
      echo '</li>';
    }