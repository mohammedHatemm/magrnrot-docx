<?php

namespace Maxime\Job\Ui\DataProvider\Department;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Maxime\Job\Model\ResourceModel\Department\CollectionFactory;

class DepartmentGridDataProvider extends AbstractDataProvider
{
  protected $loadedData;

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
        'department_id' => $item->getDepartmentId(),
        'department_name' => $item->getDepartmentName(),
        'department_description' => $item->getDepartmentDescription()
      ];
      $this->loadedData[] = $itemData;
    }

    return [
      'totalRecords' => $this->collection->getSize(),
      'items' => $this->loadedData
    ];
  }
}
