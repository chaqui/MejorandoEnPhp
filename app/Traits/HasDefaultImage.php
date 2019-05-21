<?php

namespace app\Traits;

/**
 *
 */
trait HasDefaultImage
{
  public function getImage($title)
  {
    if(!$this->imange){
      return "https://ui-avatars.com/api/?name=$title&size=160";
    }
    return $this->imange;
  }
}
