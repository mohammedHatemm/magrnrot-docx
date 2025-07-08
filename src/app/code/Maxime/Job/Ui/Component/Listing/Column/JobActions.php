<?php

namespace Maxime\Job\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class JobActions extends Column
{
  protected $urlBuilder;

  public function __construct(
    UrlInterface $urlBuilder,
    \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
    \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
    array $components = [],
    array $data = []
  ) {
    $this->urlBuilder = $urlBuilder;
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }

  public function prepareDataSource(array $dataSource)
  {
    if (isset($dataSource['data']['items'])) {
      foreach ($dataSource['data']['items'] as &$item) {
        if (isset($item['job_id'])) {
          $item[$this->getData('name')] = [
            'edit' => [
              'href' => $this->urlBuilder->getUrl(
                'job/job/edit',
                ['id' => $item['job_id']]
              ),
              'label' => __('Edit'),
            ],
            'delete' => [
              'href' => $this->urlBuilder->getUrl(
                'job/job/delete',
                ['id' => $item['job_id']]
              ),
              'label' => __('Delete'),
              'confirm' => [
                'title' => __('Delete "%1"'),
                'message' => __('Are you sure you want to delete "%1"?'),
                'args' => [
                  'job_title'
                ]
              ],
            ]
          ];
        }
      }
    }

    return $dataSource;
  }
}
