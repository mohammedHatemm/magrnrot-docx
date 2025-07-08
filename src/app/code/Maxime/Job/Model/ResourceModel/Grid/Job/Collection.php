<?php

namespace Maxime\Job\Model\ResourceModel\Grid\Job;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
  protected function _initSelect()
  {
    parent::_initSelect();

    $this->getSelect()->joinLeft(
      ['d' => $this->getTable('maxime_department')],
      'main_table.department_id = d.department_id',
      ['department_name' => 'd.name']
    );

    return $this;
  }
}
