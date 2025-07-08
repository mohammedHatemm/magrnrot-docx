<?php

namespace Maxime\Job\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Department extends AbstractDb
{

  protected function _construct()
  {
    $this->_init("maxime_department", "department_id");
  }
}
