<?php
  require_once'vendor/autoload.php';

  use app\Models\{Job, Project};
  $name ="Josué Fuentes";
  $limitmonths =35;



  $jobs = Job::all();
  $projects = Project::all();
    function printElement( $job){
      // if(!$job->getVisible()){
      //   return;
      // }
      echo '<li class="work-position">';
      echo " <h5>".$job->title."</h5>";
      echo " <p>".$job->description ."</p>";
      echo " <p>".$job->getDurationAsString() ."</p>";
      echo '<strong>Achievements:</strong>';
      echo ' <ul>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
      echo '</ul>';
      echo '</li>';
    }