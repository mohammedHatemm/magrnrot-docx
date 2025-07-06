<?php

namespace Maxime\Job\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Job extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'maxime_job_job';

    protected $_cacheTag = 'maxime_job_job';
    protected $_eventPrefix = 'maxime_job_job';

    protected function _construct()
    {
        $this->_init(\Maxime\Job\Model\ResourceModel\Job::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        return ['job_status' => '1'];
    }

    public function getJobId()
    {
        return $this->getData('job_id');
    }
    public function setJobId($id)
    {
        return $this->setData('job_id', $id);
    }

    public function getJobTitle()
    {
        return $this->getData('job_title');
    }
    public function setJobTitle($val)
    {
        return $this->setData('job_title', $val);
    }

    public function getJobLocation()
    {
        return $this->getData('job_location');
    }
    public function setJobLocation($val)
    {
        return $this->setData('job_location', $val);
    }

    public function getJobType()
    {
        return $this->getData('job_type');
    }
    public function setJobType($val)
    {
        return $this->setData('job_type', $val);
    }

    public function getJobStartedAt()
    {
        return $this->getData('job_started_at');
    }
    public function setJobStartedAt($val)
    {
        return $this->setData('job_started_at', $val);
    }

    public function getJobEndedAt()
    {
        return $this->getData('job_ended_at');
    }
    public function setJobEndedAt($val)
    {
        return $this->setData('job_ended_at', $val);
    }

    public function getDepartmentId()
    {
        return $this->getData('department_id');
    }
    public function setDepartmentId($val)
    {
        return $this->setData('department_id', $val);
    }

    public function getJobStatus()
    {
        return $this->getData('job_status');
    }
    public function setJobStatus($val)
    {
        return $this->setData('job_status', $val);
    }


    public function getDepartmentName()
    {
        return $this->getData('department_name');
    }
    public function setDepartmentName($val)
    {
        return $this->setData('department_name', $val);
    }

    public function beforeSave()
    {
        if ($this->getJobStartedAt()) {
            $this->setJobStartedAt(date('Y-m-d H:i:s', strtotime($this->getJobStartedAt())));
        }
        if ($this->getJobEndedAt()) {
            $this->setJobEndedAt(date('Y-m-d H:i:s', strtotime($this->getJobEndedAt())));
        }

        return parent::beforeSave();
    }
}
