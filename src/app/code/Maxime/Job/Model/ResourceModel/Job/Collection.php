<?php

namespace Maxime\Job\Model\ResourceModel\Job;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class JobCollection extends AbstractCollection
{
  protected $_idFieldName = "job_id";
  protected function _construct()
  {
    $this->_init(
      "Maxime\Job\Model\Job",
      "Maxime\Job\Model\ResourceModel\Job"
    );
  }
}
