<?php
namespace  app\Services;
use app\Models\Job;
use Aura\Router\Exception;

class JobService{
  public function deleteJob($id)
  {
    $job = Job::where("idjobs",$id)->first();
    if(!$job){
      throw new Exception("no exciste el Job");
    }
    $job->delete();
  }
}