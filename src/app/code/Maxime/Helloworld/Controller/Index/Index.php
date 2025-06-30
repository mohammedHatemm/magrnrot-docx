<?php

namespace Maxime\Helloworld\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
  public function execute()
  {
    echo "execute action index_index is ok ";
    die();
  }
}
