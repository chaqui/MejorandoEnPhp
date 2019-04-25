<?php
namespace  app\Models;

use Illuminate\Database\Eloquent\Model ;
class Project extends Model{
  protected $table = "projects";

  public function getDurationAsString(){
    $years = floor($this->months/12);
    $extraMonths = $this->months %12;
    return "Project duraction: $years years $extraMonths months";
  }
}