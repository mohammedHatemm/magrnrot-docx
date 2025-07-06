<?php

namespace Maxime\Job\Block\Adminhtml\Job\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;
use Magento\Store\Model\System\Store;
use Maxime\Job\Model\ResourceModel\Department\CollectionFactory as DepartmentCollectionFactory;

class Form extends Generic
{
  /**
   * @var Store
   */
  protected $systemStore;

  /**
   * @var DepartmentCollectionFactory
   */
  protected $departmentCollectionFactory;

  /**
   * Constructor
   */
  public function __construct(
    Context $context,
    Registry $registry,
    FormFactory $formFactory,
    Store $systemStore,
    DepartmentCollectionFactory $departmentCollectionFactory,
    array $data = []
  ) {
    $this->systemStore = $systemStore;
    $this->departmentCollectionFactory = $departmentCollectionFactory;
    parent::__construct($context, $registry, $formFactory, $data);
  }

  /**
   * Prepare form
   */
  protected function _prepareForm()
  {
    /** @var \Maxime\Job\Model\Job $model */
    $model = $this->_coreRegistry->registry('current_job');

    if (!$model) {
      throw new \Magento\Framework\Exception\LocalizedException(__('Job model is not available'));
    }

    $form = $this->_formFactory->create([
      'data' => [
        'id' => 'edit_form',
        'action' => $this->getData('action'),
        'method' => 'post',
        'enctype' => 'multipart/form-data'
      ]
    ]);

    $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Job Information'), 'class' => 'fieldset-wide']);

    if ($model->getId()) {
      $fieldset->addField('job_id', 'hidden', ['name' => 'job_id']);
    }

    $fieldset->addField(
      'job_title',
      'text',
      [
        'name' => 'job_title',
        'label' => __('Title'),
        'title' => __('Title'),
        'required' => true,
      ]
    );

    $fieldset->addField(
      'job_location',
      'textarea',
      [
        'name' => 'job_location',
        'label' => __('Location'),
        'title' => __('Location'),
        'required' => true,
      ]
    );

    $fieldset->addField(
      'job_type',
      'select',
      [
        'name' => 'job_type',
        'label' => __('Type'),
        'title' => __('Type'),
        'values' => [
          ['value' => 'full-time', 'label' => __('Full-time')],
          ['value' => 'part-time', 'label' => __('Part-time')],
          ['value' => 'internship', 'label' => __('Internship')], // إصلاح الخطأ هنا
        ],
      ]
    );

    $fieldset->addField(
      'job_started_at',
      'date',
      [
        'name' => 'job_started_at',
        'label' => __('Started At'),
        'title' => __('Started At'),
        'required' => true,
        'date_format' => 'yyyy-MM-dd',
      ]
    );

    $fieldset->addField(
      'job_ended_at',
      'date',
      [
        'name' => 'job_ended_at',
        'label' => __('Ended At'),
        'title' => __('Ended At'),
        'required' => false,
        'date_format' => 'yyyy-MM-dd',
      ]
    );

    $fieldset->addField(
      'department_id',
      'select',
      [
        'name' => 'department_id',
        'label' => __('Department'),
        'title' => __('Department'),
        'values' => $this->getDepartmentOptions(),
      ]
    );

    $fieldset->addField(
      'job_status',
      'select',
      [
        'name' => 'job_status',
        'label' => __('Status'),
        'title' => __('Status'),
        'required' => true,
        'values' => [
          ['value' => '', 'label' => __('Please Select')],
          ['value' => 1, 'label' => __('Enabled')],
          ['value' => 0, 'label' => __('Disabled')],
        ],
      ]
    );

    $form->setUseContainer(true);

    // تحضير البيانات للعرض
    $data = $model->getData();

    // تحويل التواريخ للتنسيق المطلوب
    if (isset($data['job_started_at'])) {
      $data['job_started_at'] = date('Y-m-d', strtotime($data['job_started_at']));
    }
    if (isset($data['job_ended_at'])) {
      $data['job_ended_at'] = date('Y-m-d', strtotime($data['job_ended_at']));
    }

    // تعيين القيم
    $form->setValues($data);
    $this->setForm($form);

    return parent::_prepareForm();
  }

  /**
   * Get Department Options
   * @return array
   */
  public function getDepartmentOptions()
  {
    $options = [['value' => '', 'label' => __('Please Select')]];

    try {
      $departmentCollection = $this->departmentCollectionFactory->create();
      foreach ($departmentCollection as $department) {
        $options[] = [
          'value' => $department->getId(),
          'label' => $department->getDepartmentName() // تأكد من استخدام الطريقة الصحيحة
        ];
      }
    } catch (\Exception $e) {
      // Handle exception if department collection is not available
      $this->_logger->error('Error loading department options: ' . $e->getMessage());
    }

    return $options;
  }
}
