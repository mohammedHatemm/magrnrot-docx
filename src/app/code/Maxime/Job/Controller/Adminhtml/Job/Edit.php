<?php

namespace Maxime\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Registry;
use Maxime\Job\Model\Job;

class Edit extends Action
{
  protected $_coreRegistry;
  protected $resultPageFactory;
  protected $jobModel;

  public function __construct(
    Context $context,
    PageFactory $resultPageFactory,
    Registry $registry,
    Job $jobModel
  ) {
    $this->resultPageFactory = $resultPageFactory;
    $this->_coreRegistry = $registry;
    $this->jobModel = $jobModel;
    parent::__construct($context);
  }

  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Maxime_Job::job');
  }

  protected function _initAction()
  {
    /** @var Page $resultPage */
    $resultPage = $this->resultPageFactory->create();

    $resultPage->setActiveMenu('Maxime_Job::job')
      ->addBreadcrumb(__('Job'), __('Job'))
      ->addBreadcrumb(__('Manage Jobs'), __('Manage Jobs'));

    return $resultPage;
  }

  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    $model = $this->jobModel;

    if ($id) {
      $model->load($id);
      if (!$model->getId()) {
        $this->messageManager->addErrorMessage(__('This job does not exist.'));
        return $this->resultRedirectFactory->create()->setPath('*/*/');
      }
    }

    $data = $this->_getSession()->getFormData(true);
    if (!empty($data)) {
      $model->setData($data);
    }

    $this->_coreRegistry->register('current_job', $model);

    try {
      $resultPage = $this->_initAction();
      $resultPage->addBreadcrumb(
        $id ? __('Edit Job') : __('New Job'),
        $id ? __('Edit Job') : __('New Job')
      );
      $resultPage->getConfig()->getTitle()->prepend(__('Jobs'));
      $resultPage->getConfig()->getTitle()
        ->prepend($model->getId() ? $model->getTitle() : __('New Job'));

      return $resultPage;
    } catch (\Exception $e) {
      $this->messageManager->addErrorMessage(__('An error occurred: %1', $e->getMessage()));
      return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
  }
}
