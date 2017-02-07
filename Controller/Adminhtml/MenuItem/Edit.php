<?php
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry)
    {
        $this->_coreRegistry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $menuitem = $this->_objectManager->create('Sahir\MegaMenu\Model\MenuItem');
        $menuitem_id = NULL;
        if ($this->getRequest()->isPost()) {
            $menuitem_id = $this->getRequest()->getParam('menuitem_id');
            if ($menuitem_id) {
                $menuitem->load($menuitem_id);
                if (!$menuitem->getId()) {
                    $this->messageManager->addError(__('This menu item no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }
        }
        $this->_coreRegistry->register('menuitem', $menuitem);
        $page = $this->resultPageFactory->create();
        $page->setActiveMenu('Sahir_MegaMenu::sahir_megamenu_menu')
                ->addBreadcrumb(__('Mega Menu'), __('Mega Menu'))
                ->addBreadcrumb(__('Manage Menu Items'), __('Manage Menu Items'));
        if ($menuitem_id) {
            $page->addBreadcrumb(__('Edit Menu Item'), __('Edit Menu Item'));
            $page->getConfig()->getTitle()->prepend(__('Edit Menu Item'));
        } else {
            $page->addBreadcrumb(__('New Menu Item'), __('New Menu Item'));
            $page->getConfig()->getTitle()->prepend(__('Create New Menu Item'));
        }
        return $page;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sahir_MegaMenu::config');
    }

}
