<?php

namespace Maxime\Job\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class DepartmentCollection extends AbstractCollection
{
  protected $_idFieldName = "department_id";

  protected function _construct()
  {
    $this->_init(
      "Maxime\Job\Model\Department",
      "Maxime\Job\Model\ResourceModel\Department"
    );
  }
}
