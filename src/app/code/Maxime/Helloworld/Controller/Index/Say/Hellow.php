<?php

namespace Maxime\Helloworld\Controller\Index\Say;


use Magento\Framework\App\Action\Action;


class Hellow extends Action
{
  public function execute()
  {
    $this->_view->loadLayout();
    $this->_view->getLayout()->initMessages();
    $this->_view->renderLayout();
  }
}
