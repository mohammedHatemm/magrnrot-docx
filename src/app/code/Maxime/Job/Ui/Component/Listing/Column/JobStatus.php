<?php

namespace Maxime\Job\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Maxime\Job\Ui\Component\Options\JobStatus as JobStatusOptions;

class JobStatus extends Column
{
  protected $jobStatusOptions;

  public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    JobStatusOptions $jobStatusOptions,
    array $components = [],
    array $data = []
  ) {
    $this->jobStatusOptions = $jobStatusOptions;
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource(array $dataSource)
  {
    if (isset($dataSource['data']['items'])) {
      foreach ($dataSource['data']['items'] as &$item) {
        if (isset($item['job_status'])) {
          $options = $this->jobStatusOptions->toOptionArray();
          foreach ($options as $option) {
            if ($option['value'] == $item['job_status']) {
              $item['job_status'] = $option['label'];
              break;
            }
          }
        }
      }
    }
    return $dataSource;
  }
}
