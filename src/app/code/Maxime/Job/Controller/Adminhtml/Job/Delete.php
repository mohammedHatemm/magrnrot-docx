<?php

namespace Maxime\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;

class Delete extends Action
{
  protected $_model;

  /**
   * @param Action\Context $context
   * @param \Maxime\Job\Model\Job $model
   */
  public function __construct(
    Action\Context $context,
    \Maxime\Job\Model\Job $model
  ) {
    parent::__construct($context);
    $this->_model = $model;
  }

  /**
   * {@inheritdoc}
   */
  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Maxime_Job:: job_delete');
  }

  /**
   * Delete action
   *
   * @return \Magento\Framework\Controller\ResultInterface
   */
  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
    $resultRedirect = $this->resultRedirectFactory->create();
    if ($id) {
      try {
        $model = $this->_model;
        $model->load($id);
        $model->delete();
        $this->messageManager->addSuccess(__('Job deleted'));
        return $resultRedirect->setPath('*/*/');
      } catch (\Exception $e) {
        $this->messageManager->addError($e->getMessage());
        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
      }
    }
    $this->messageManager->addError(__('Job does not exist'));
    return $resultRedirect->setPath('*/*');
  }
}
