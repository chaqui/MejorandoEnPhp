<?php
namespace  app\Models;

class Job extends BaseElement{
  public function __construct($title, $descripcion){
    $newTitle = 'Job: '.$title;
    parent::__construct($newTitle, $descripcion);
  }

  public function getDurationAsString(){
    $years = floor($this->months/12);
    $extraMonths = $this->months %12;
    return "Job duraction: $years years $extraMonths months";
  }
}