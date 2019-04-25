<?php
namespace  app\Models;

use Illuminate\Database\Eloquent\Model ;
class Job extends Model {
  protected $table = "jobs";

  public function getDurationAsString(){
    $years = floor($this->months/12);
    $extraMonths = $this->months %12;
    return "Job duraction: $years years $extraMonths months";
  }
}