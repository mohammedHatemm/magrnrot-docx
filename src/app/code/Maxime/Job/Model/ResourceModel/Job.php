<?php

namespace Maxime\Job\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Job extends AbstractDb
{

  protected function _construct()
  {
    $this->_init("maxime_job", "job_id");
  }
}
