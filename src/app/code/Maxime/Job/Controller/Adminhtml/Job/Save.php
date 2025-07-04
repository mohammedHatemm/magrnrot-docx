<?php

namespace Maxime\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Maxime\Job\Model\JobFactory;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
  /**
   * @var JobFactory
   */
  protected $jobFactory;

  /**
   * Constructor
   *
   * @param Context $context
   * @param JobFactory $jobFactory
   */
  public function __construct(
    Context $context,
    JobFactory $jobFactory
  ) {
    $this->jobFactory = $jobFactory;
    parent::__construct($context);
  }

  /**
   * Save action
   *
   * @return \Magento\Framework\Controller\ResultInterface
   */
  public function execute()
  {
    /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
    $resultRedirect = $this->resultRedirectFactory->create();

    $data = $this->getRequest()->getPostValue();

    if ($data) {
      $id = $this->getRequest()->getParam('job_id');
      $model = $this->jobFactory->create();

      if ($id) {
        $model->load($id);
        if (!$model->getId()) {
          $this->messageManager->addErrorMessage(__('This job no longer exists.'));
          return $resultRedirect->setPath('*/*/');
        }
      }

      // تحضير البيانات للحفظ
      $model->setData($data);

      // تحويل التواريخ للتنسيق المطلوب
      if (isset($data['job_started_at'])) {
        $model->setJobStartedAt(date('Y-m-d H:i:s', strtotime($data['job_started_at'])));
      }

      if (isset($data['job_ended_at']) && !empty($data['job_ended_at'])) {
        $model->setJobEndedAt(date('Y-m-d H:i:s', strtotime($data['job_ended_at'])));
      }

      // تعيين القيم المباشرة
      $model->setJobTitle($data['job_title']);
      $model->setJobLocation($data['job_location']);
      $model->setJobType($data['job_type']);
      $model->setJobStatus($data['job_status']);
      $model->setJobDepartmentId($data['job_department_id']);

      try {
        $model->save();
        $this->messageManager->addSuccessMessage(__('You saved the job.'));
        $this->_session->setFormData(false);

        if ($this->getRequest()->getParam('back')) {
          return $resultRedirect->setPath('*/*/edit', ['job_id' => $model->getJobId()]);
        }

        return $resultRedirect->setPath('*/*/');
      } catch (LocalizedException $e) {
        $this->messageManager->addErrorMessage($e->getMessage());
      } catch (\Exception $e) {
        $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the job.'));
      }

      $this->_session->setFormData($data);
      return $resultRedirect->setPath('*/*/edit', ['job_id' => $this->getRequest()->getParam('job_id')]);
    }

    return $resultRedirect->setPath('*/*/');
  }

  /**
   * Check permission via ACL resource
   *
   * @return bool
   */
  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Maxime_Job::job_save');
  }
}
