<?php

namespace Maxime\Job\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Job extends AbstractModel implements IdentityInterface
{
  /**
   * Job cache tag
   */
  const CACHE_TAG = 'maxime_job_job';

  /**
   * @var string
   */
  protected $_cacheTag = 'maxime_job_job';

  /**
   * Prefix of model events names
   *
   * @var string
   */
  protected $_eventPrefix = 'maxime_job_job';

  /**
   * Initialize resource model
   *
   * @return void
   */
  protected function _construct()
  {
    $this->_init('Maxime\Job\Model\ResourceModel\Job');
  }

  /**
   * Return unique ID(s) for each object in system
   *
   * @return array
   */
  public function getIdentities()
  {
    return [self::CACHE_TAG . '_' . $this->getId()];
  }

  /**
   * Get default values
   *
   * @return array
   */
  public function getDefaultValues()
  {
    $values = [];
    $values['job_status'] = '1';
    return $values;
  }

  /**
   * Getters and Setters
   */

  public function getJobId()
  {
    return $this->getData('job_id');
  }

  public function setJobId($jobId)
  {
    return $this->setData('job_id', $jobId);
  }

  public function getJobTitle()
  {
    return $this->getData('job_title');
  }

  public function setJobTitle($jobTitle)
  {
    return $this->setData('job_title', $jobTitle);
  }

  public function getJobLocation()
  {
    return $this->getData('job_location');
  }

  public function setJobLocation($jobLocation)
  {
    return $this->setData('job_location', $jobLocation);
  }

  public function getJobType()
  {
    return $this->getData('job_type');
  }

  public function setJobType($jobType)
  {
    return $this->setData('job_type', $jobType);
  }

  public function getJobStartedAt()
  {
    return $this->getData('job_started_at');
  }

  public function setJobStartedAt($jobStartedAt)
  {
    return $this->setData('job_started_at', $jobStartedAt);
  }

  public function getJobEndedAt()
  {
    return $this->getData('job_ended_at');
  }

  public function setJobEndedAt($jobEndedAt)
  {
    return $this->setData('job_ended_at', $jobEndedAt);
  }

  public function getJobDepartmentId()
  {
    return $this->getData('job_department_id');
  }

  public function setJobDepartmentId($jobDepartmentId)
  {
    return $this->setData('job_department_id', $jobDepartmentId);
  }

  public function getJobStatus()
  {
    return $this->getData('job_status');
  }

  public function setJobStatus($jobStatus)
  {
    return $this->setData('job_status', $jobStatus);
  }

  public function getDepartmentName()
  {
    return $this->getData('department_name');
  }

  public function setDepartmentName($departmentName)
  {
    return $this->setData('department_name', $departmentName);
  }

  /**
   * Prepare data before save
   *
   * @return $this
   */
  public function beforeSave()
  {
    // تحويل التواريخ للتنسيق المطلوب
    if ($this->getJobStartedAt()) {
      $this->setJobStartedAt(date('Y-m-d H:i:s', strtotime($this->getJobStartedAt())));
    }

    if ($this->getJobEndedAt()) {
      $this->setJobEndedAt(date('Y-m-d H:i:s', strtotime($this->getJobEndedAt())));
    }

    return parent::beforeSave();
  }
}
