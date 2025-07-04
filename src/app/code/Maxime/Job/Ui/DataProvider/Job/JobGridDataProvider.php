<?php

namespace Maxime\Job\Ui\DataProvider\Job;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Maxime\Job\Model\ResourceModel\Job\CollectionFactory;

class JobGridDataProvider extends AbstractDataProvider
{
  protected $loadedData;
  protected $collection;

  public function __construct(
    $name,
    $primaryFieldName,
    $requestFieldName,
    CollectionFactory $collectionFactory,
    array $meta = [],
    array $data = []
  ) {
    $this->collection = $collectionFactory->create();
    parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
  }

  public function getData()
  {
    if (isset($this->loadedData)) {
      return $this->loadedData;
    }

    $items = $this->collection->getItems();
    $this->loadedData = [];

    foreach ($items as $item) {
      $itemData = [
        'job_id' => $item->getJobId(),
        'job_title' => $item->getJobTitle(),
        'job_location' => $item->getJobLocation(),
        'job_type' => $item->getJobType(),
        'job_started_at' => $item->getJobStartedAt(),
        'job_ended_at' => $item->getJobEndedAt(), // إضافة تاريخ الانتهاء
        'job_status' => $item->getJobStatus(),
        'job_department_id' => $item->getJobDepartmentId(),
        'job_department_name' => $item->getDepartmentName()

      ];
      $this->loadedData[$item->getJobId()] = $itemData;
    }

    return $this->loadedData;
  }
}
