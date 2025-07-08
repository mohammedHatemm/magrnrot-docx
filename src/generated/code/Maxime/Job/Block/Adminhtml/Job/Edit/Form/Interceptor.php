<?php
namespace Maxime\Job\Block\Adminhtml\Job\Edit\Form;

/**
 * Interceptor class for @see \Maxime\Job\Block\Adminhtml\Job\Edit\Form
 */
class Interceptor extends \Maxime\Job\Block\Adminhtml\Job\Edit\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Magento\Store\Model\System\Store $systemStore, \Maxime\Job\Model\ResourceModel\Department\CollectionFactory $departmentCollectionFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $systemStore, $departmentCollectionFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getForm');
        return $pluginInfo ? $this->___callPlugins('getForm', func_get_args(), $pluginInfo) : parent::getForm();
    }
}
