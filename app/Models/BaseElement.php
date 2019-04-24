<?php

class BaseElement {
  private $title;
  private $description;
  private $visible=true;
  protected $months;


  public function __construct($title, $description){
    $this->setTitle($title);
    $this->setDescription($description);
  }
  public function getTitle(){
    return $this->title;
  }
  public function setTitle($title){
    if($title =='' || $title == "" )
    {
      $this->title='N/A';
      return;
    }
    $this->title=$title;
  }
  public function getDescription(){
    return $this->description;
  }
  public function setDescription($description){
    $this->description=$description;
  }
  public function getVisible(){
    return $this->visible;
  }
  public function setVisible($visible){
    $this->visible=$visible;
  }
  public function getMonths(){
    return $this->months;
  }
  public function setMonths($months){
    $this->months=$months;
  }
  public function getDurationAsString(){
    $years = floor($this->months/12);
    $extraMonths = $this->months %12;
    return "$years years $extraMonths months";
  }
}
