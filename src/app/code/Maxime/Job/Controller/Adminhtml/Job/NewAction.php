<?php

namespace Maxime\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;

class NewAction extends Action
{


  /**
   * @var \Magento\Backend\Model\View\Result\ForwardFactory
   */
  protected $_resultForwardFactory;

  /**
   * @param \Magento\Backend\App\Action\Context $context
   */
  public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
  ) {
    $this->_resultForwardFactory = $resultForwardFactory;
    return parent::__construct($context);
  }

  /**
   * Is the user allowed to view the page.
   *
   * @return bool
   */
  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Maxime_Job::job_save');
  }




  /**
   * Forward to edit
   *
   * @return \Magento\Backend\Model\View\Result\Forward
   */
  public function execute()
  {
    /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
    $resultForward = $this->_resultForwardFactory->create();
    return $resultForward->forward('edit');
  }
}
