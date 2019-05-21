<?php
namespace app\Controllers;
use app\Models\{Job,Project};

class AdminController extends BaseController{
  public function getIndex(){
    return $this->renderHTML('admin.twig');
  }
}