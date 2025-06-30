<?php

namespace Maxime\Job\Controller\Adminhtml\Department;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
  const ADMIN_RESOURCE = 'Maxime_Job::department';

  /**
   * @var PageFactory
   */
  protected $resultPageFactory;

  /**
   * @param Context $context
   * @param PageFactory $resultPageFactory
   */
  public function __construct(
    Context $context,
    PageFactory $resultPageFactory
  ) {
    parent::__construct($context);
    $this->resultPageFactory = $resultPageFactory;
  }

  /**
   * Index action
   *
   * @return \Magento\Backend\Model\View\Result\Page
   */
  public function execute()
  {
    /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
    $resultPage = $this->resultPageFactory->create();
    $resultPage->setActiveMenu('Maxime_Job::department');
    $resultPage->addBreadcrumb(__('Job'), __('Job'));
    $resultPage->addBreadcrumb(__('Manage Department'), __('Manage Department'));
    $resultPage->getConfig()->getTitle()->prepend(__('Department'));

    return $resultPage;
  }
}
