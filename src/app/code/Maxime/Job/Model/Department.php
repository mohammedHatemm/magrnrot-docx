<?php

namespace Maxime\Job\Model;

use Magento\Framework\Model\AbstractModel;

class Department extends AbstractModel
{
  const DEPARTMENT_ID = "department_id";
  protected $_eventPrefix = "job";
  protected $_eventObject = "department";
  protected $_idFieldName = self::DEPARTMENT_ID;

  protected function _construct()
  {
    $this->_init("Maxime\Job\Model\ResourceModel\Department");
  }
}
