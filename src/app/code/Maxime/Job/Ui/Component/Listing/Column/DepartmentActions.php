<?php

namespace Maxime\Job\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class DepartmentActions extends Column
{
  const URL_PATH_EDIT = 'maxime_job/department/edit';
  const URL_PATH_DELETE = 'maxime_job/department/delete';

  /**
   * @var UrlInterface
   */
  protected $urlBuilder;

  public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    UrlInterface $urlBuilder,
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
        if (isset($item['department_id'])) {
          $id = $item['department_id'];
          $item[$this->getData('name')] = [
            'edit' => [
              'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['id' => $id]),
              'label' => __('Edit'),
            ],
            'delete' => [
              'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $id]),
              'label' => __('Delete'),
              'confirm' => [
                'title' => __('Delete Department'),
                'message' => __('Are you sure you want to delete this department?')
              ]
            ]
          ];
        }
      }
    }

    return $dataSource;
  }
}
