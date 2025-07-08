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
  public function getDepartmentId()
  {
    return $this->getData('department_id');
  }

  public function getDepartmentName()
  {
    return $this->getData('department_name');
  }

  public function getDepartmentDescription()
  {
    return $this->getData('department_description');
  }

  public function setDepartmentName($name)
  {
    return $this->setData('department_name', $name);
  }

  public function setDepartmentDescription($description)
  {
    return $this->setData('department_description', $description);
  }
}
