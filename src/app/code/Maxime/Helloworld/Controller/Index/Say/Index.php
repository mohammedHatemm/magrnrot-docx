<?php

namespace Maxime\Helloworld\Controller\Index\Say;


use Magento\Framework\App\Action\Action;

class Index extends Action
{
  public function execute()
  {
    echo "execute action say_index is ok ";
    die();
  }
}
