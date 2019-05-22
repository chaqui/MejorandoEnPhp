<?php
namespace  app\Services;
use app\Models\Job;

class JobService{
  public function deleteJob($id)
  {
    $job = Job::where($id);
    $job->delete();
  }
}