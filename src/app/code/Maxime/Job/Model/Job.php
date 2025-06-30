<?php

namespace Maxime\Job\Model;

use Magento\Framework\Model\AbstractModel;

class Job extends AbstractModel
{
  const JOB_ID = "job_id";
  protected $_eventPrefix = "job";
  protected $_eventObject = "job";
  protected $_idFieldName = self::JOB_ID;

  protected function _construct()
  {
    $this->_init(\Maxime\Job\Model\ResourceModel\Job::class);
  }
}
