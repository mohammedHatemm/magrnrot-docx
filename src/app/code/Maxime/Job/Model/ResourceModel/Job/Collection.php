<?php

namespace Maxime\Job\Model\ResourceModel\Job;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
  protected $_idFieldName = "job_id";

  protected function _construct()
  {
    $this->_init(
      \Maxime\Job\Model\Job::class,
      \Maxime\Job\Model\ResourceModel\Job::class
    );
  }

  protected function _initSelect()
  {
    parent::_initSelect();

    $this->getSelect()->joinLeft(
      ['d' => $this->getTable('maxime_department')],
      'main_table.department_id = d.department_id',
      ['department_name']
    );

    return $this;
  }
}
