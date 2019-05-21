<?php
namespace  app\Models;

use Illuminate\Database\Eloquent\Model ;
use app\Traits\HasDefaultImage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model {
  use HasDefaultImage;
  use SoftDeletes;
  protected $table = "jobs";

  public function getDurationAsString(){
    $years = floor($this->months/12);
    $extraMonths = $this->months %12;
    return "Job duraction: $years years $extraMonths months";
  }
}