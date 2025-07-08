<?php

namespace Maxime\Job\Block\Adminhtml\Job;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
  /**
   * @var Registry
   */
  protected $coreRegistry;

  /**
   * Constructor
   *
   * @param Context $context
   * @param Registry $registry
   * @param array $data
   */
  public function __construct(
    Context $context,
    Registry $registry,
    array $data = []
  ) {
    $this->coreRegistry = $registry;
    parent::__construct($context, $data);
  }

  /**
   * Initialize cms page edit block
   *
   * @return void
   */
  protected function _construct()
  {
    $this->_objectId = 'job_id';
    $this->_blockGroup = 'Maxime_Job';
    $this->_controller = 'adminhtml_job';

    parent::_construct();

    if ($this->_isAllowedAction('Maxime_Job::job_save')) {
      $this->buttonList->update('save', 'label', __('Save Job'));
      $this->buttonList->add(
        'saveandcontinue',
        [
          'label' => __('Save and Continue Edit'),
          'class' => 'save',
          'data_attribute' => [
            'mage-init' => [
              'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']
            ]
          ]
        ],
        -100
      );
    } else {
      $this->buttonList->remove('save');
    }

    if ($this->_isAllowedAction('Maxime_Job::job_delete')) {
      $this->buttonList->update('delete', 'label', __('Delete Job'));
    } else {
      $this->buttonList->remove('delete');
    }
  }

  /**
   * Get header with Job title
   *
   * @return \Magento\Framework\Phrase
   */
  public function getHeaderText()
  {
    /** @var \Maxime\Job\Model\Job $job */
    $job = $this->coreRegistry->registry('current_job');
    if ($job->getId()) {
      return __("Edit Job '%1'", $this->escapeHtml($job->getJobTitle()));
    } else {
      return __('New Job');
    }
  }

  /**
   * Check permission for passed action
   *
   * @param string $resourceId
   * @return bool
   */
  protected function _isAllowedAction($resourceId)
  {
    return $this->_authorization->isAllowed($resourceId);
  }

  /**
   * Get form save URL
   *
   * @see getFormActionUrl()
   * @return string
   */
  public function getFormActionUrl()
  {
    if ($this->hasFormActionUrl()) {
      return $this->getData('form_action_url');
    }
    return $this->getUrl('*/*/save');
  }
}
