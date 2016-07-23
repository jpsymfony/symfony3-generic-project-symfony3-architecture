<?php

namespace App\BackUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBackUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
