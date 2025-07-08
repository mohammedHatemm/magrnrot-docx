<?php

namespace Maxime\Job\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Maxime\Job\Model\JobFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\Filter\Date as DateFilter; // استيراد فلتر التاريخ الخاص بماجنتو

class Save extends Action
{
  /**
   * @var JobFactory
   */
  protected $jobFactory;

  /**
   * @var DateFilter
   */
  protected $dateFilter;

  /**
   * Constructor
   *
   * @param Context $context
   * @param JobFactory $jobFactory
   * @param DateFilter $dateFilter
   */
  public function __construct(
    Context $context,
    JobFactory $jobFactory,
    DateFilter $dateFilter // حقن فلتر التاريخ
  ) {
    $this->jobFactory = $jobFactory;
    $this->dateFilter = $dateFilter;
    parent::__construct($context);
  }

  /**
   * Save action
   *
   * @return \Magento\Framework\Controller\ResultInterface
   */
  public function execute()
  {
    $resultRedirect = $this->resultRedirectFactory->create();
    $data = $this->getRequest()->getPostValue();

    if ($data) {
      // --- التحقق من البيانات (Validation) ---
      // هذا هو السبب الأكثر احتمالاً للمشكلة
      if (empty($data['department_id'])) {
        $this->messageManager->addErrorMessage(__('Please select a department. It is a required field.'));
        $this->_session->setFormData($data);
        $id = $this->getRequest()->getParam('job_id');
        return $resultRedirect->setPath('*/*/edit', ['job_id' => $id]);
      }

      $id = $this->getRequest()->getParam('job_id');
      $model = $this->jobFactory->create();

      if ($id) {
        $model->load($id);
        if (!$model->getId()) {
          $this->messageManager->addErrorMessage(__('This job no longer exists.'));
          return $resultRedirect->setPath('*/*/');
        }
      }

      // --- معالجة التواريخ بالطريقة الصحيحة ---
      // استخدم فلتر ماجنتو الموثوق بدلاً من strtotime
      if (!empty($data['started_at'])) {
        $data['started_at'] = $this->dateFilter->filter($data['started_at']);
      }
      if (!empty($data['ended_at'])) {
        $data['ended_at'] = $this->dateFilter->filter($data['ended_at']);
      } else {
        // إذا كان تاريخ الانتهاء اختيارياً، قم بتعيينه إلى NULL لتجنب الأخطاء
        $data['ended_at'] = null;
      }

      // تأكد من أن أسماء الحقول في الفورم (XML) تطابق أسماء الأعمدة في قاعدة البيانات
      $model->setData($data);

      try {
        $model->save();
        $this->messageManager->addSuccessMessage(__('You saved the job.'));
        $this->_session->setFormData(false);

        if ($this->getRequest()->getParam('back')) {
          return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
      } catch (LocalizedException $e) {
        $this->messageManager->addErrorMessage($e->getMessage());
      } catch (\Exception $e) {
        // --- رسالة خطأ أوضح ---
        // هذا سيوجهك إلى مكان الخطأ الحقيقي
        $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the job. Please check the Magento exception log for details (var/log/exception.log).'));
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
