<?php

namespace Maxime\Job\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use Maxime\Job\Model\DepartmentFactory;

class Save extends Action
{
  protected $departmentFactory;

  public function __construct(
    Action\Context $context,
    DepartmentFactory $departmentFactory
  ) {
    $this->departmentFactory = $departmentFactory;
    parent::__construct($context);
  }

  public function execute()
  {
    $data = $this->getRequest()->getPostValue();
    if (!$data) {
      return $this->_redirect('*/*/');
    }

    try {
      $model = $this->departmentFactory->create();

      if (isset($data['department_id'])) {
        $model->load($data['department_id']);
      }

      $model->setData($data);
      $model->save();

      $this->messageManager->addSuccessMessage(__('The department has been saved.'));
      return $this->_redirect('*/*/');
    } catch (\Exception $e) {
      $this->messageManager->addErrorMessage(__('Something went wrong while saving the department.'));
      return $this->_redirect('*/*/edit', ['department_id' => $data['department_id']]);
    }
  }
}
