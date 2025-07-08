<?php

namespace Maxime\Job\Ui\Component\Options;

use Magento\Framework\Data\OptionSourceInterface;
use Maxime\Job\Model\ResourceModel\Department\CollectionFactory;

class JobDepartment implements OptionSourceInterface
{
  protected $collectionFactory;

  public function __construct(CollectionFactory $collectionFactory)
  {
    $this->collectionFactory = $collectionFactory;
  }

  public function toOptionArray()
  {
    $options = [];

    $collection = $this->collectionFactory->create();

    foreach ($collection as $department) {
      $options[] = [
        'value' => $department->getId(),
        'label' => $department->getDepartmentName()
      ];
    }

    return $options;
  }
}
