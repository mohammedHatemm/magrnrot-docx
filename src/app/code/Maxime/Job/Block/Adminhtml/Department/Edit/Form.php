<?php

namespace Maxime\Job\Block\Adminhtml\Department\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

  /**
   * @var \Magento\Store\Model\System\Store
   */
  protected $_systemStore;

  /**
   * @param \Magento\Backend\Block\Template\Context $context
   * @param \Magento\Framework\Registry $registry
   * @param \Magento\Framework\Data\FormFactory $formFactory
   * @param \Magento\Store\Model\System\Store $systemStore
   * @param array $data
   */
  public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\Data\FormFactory $formFactory,
    \Magento\Store\Model\System\Store $systemStore,
    array $data = []
  ) {
    $this->_systemStore = $systemStore;
    parent::__construct($context, $registry, $formFactory, $data);
  }

  /**
   * Init form
   *
   * @return void
   */
  protected function _construct()
  {
    parent::_construct();
    $this->setId('department_form');
    $this->setTitle(__('Department Information'));
  }

  /**
   * Prepare form
   *
   * @return $this
   */
  protected function _prepareForm()
  {
    /** @var \Maxime\Job\Model\Department $model */
    $model = $this->_coreRegistry->registry('job_department');

    /** @var \Magento\Framework\Data\Form $form */
    $form = $this->_formFactory->create(
      ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
    );

    $form->setHtmlIdPrefix('department_');

    $fieldset = $form->addFieldset(
      'base_fieldset',
      ['legend' => __('General Information'), 'class' => 'fieldset-wide']
    );

    if ($model->getId()) {
      $fieldset->addField('department_id', 'hidden', ['name' => 'department_id']);
    }

    $fieldset->addField(
      'department_name',
      'text',
      ['name' => 'department_name', 'label' => __('Department Name'), 'title' => __('Department Name'), 'required' => true]
    );

    $fieldset->addField(
      'department_description',
      'textarea',
      ['name' => 'department_description', 'label' => __('Department Description'), 'title' => __('Department Description'), 'required' => true]
    );

    $form->setValues($model->getData());
    $form->setUseContainer(true);
    $this->setForm($form);

    return parent::_prepareForm();
  }
}
