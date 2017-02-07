<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    /**
     * @param Action\Context $context
     * @param \Sahir\MegaMenu\Model\MenuItemFactory $menuItemFactory
     */
    public function __construct(
        Action\Context $context,
        \Sahir\MegaMenu\Model\MenuItemFactory $menuItemFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->_menuItemFactory = $menuItemFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$this->getRequest()->isPost()) {
            $this->messageManager->addError(__("Something went wrong"));
            return $resultRedirect->setPath('*/*/');
        }
        $data = $this->getRequest()->getPostValue();
        $id = (int) $this->getRequest()->getParam("menuitem_id");
        $new_menu_item = $this->_menuItemFactory->create()->addData($data);
        if ($new_menu_item->getMenuItemType() == 1) {
            // type is url
        } else if ($new_menu_item->getMenuItemType() == 0) {
            // type is category
        } else {
            // unknown menu type
            $this->messageManager->addError(__("Unknown Menu type provided."));
            return $resultRedirect->setPath('*/*/');
        }
        if ($id > 0) {
            $this->_menuItemFactory->create()->addData($data)->setId($id)->save();
        } else {
            $this->_menuItemFactory->create()->setData($data)->save();
        }
        $this->messageManager->addSuccess(__('Menu Item saved succesfully.'));
        return $resultRedirect->setPath('*/*/');
    }

}
