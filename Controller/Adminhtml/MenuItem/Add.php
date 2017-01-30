<?php
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
class Add extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $page->setActiveMenu('Sahir_MegaMenu::sahir_megamenu_menu');
        $page->getConfig()->getTitle()->prepend(__('Add New Menu Item'));
        return $page;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sahir_MegaMenu::config');
    }

}
