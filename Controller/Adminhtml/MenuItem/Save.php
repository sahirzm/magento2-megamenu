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
        $menu_item = $this->_menuItemFactory->create();
        $menu_item->setMenuItemType($data['menu_item_type']);
        $menu_item->setMenuItemText($data['menu_item_text']);
        $menu_item->setSeoUrlKey(array_key_exists('seo_url_key', $data) ?
                                $data['seo_url_key'] : '');
        $menu_item->setIsActive($data['is_active']);
        $menu_item->setSortOrder($data['sort_order']);
        if ($menu_item->getMenuItemType() == 0) {
            // type is category
            $menu_item->setCategoryId($data['category_id']);
            $menu_item->setFilterAttributes($data['filter_attributes']);
        } else if ($menu_item->getMenuItemType() == 1) {
            // type is url
            $menu_item->setUrl($data['url']);
        } else if ($menu_item->getMenuItemType() == 2) {
            // type is products
            $menu_item->setProductIds($data['product_ids']);
        } else if ($menu_item->getMenuItemType() == 3) {
            // type is cms_page_id
            $menu_item->setCmsPageId($data['cms_page_id']);
        } else {
            // unknown menu type
            $this->messageManager->addError(__("Unknown Menu type provided."));
            return $resultRedirect->setPath('*/*/');
        }
        if ($id > 0) {
            $menu_item->setId($id)->save();
        } else {
            $menu_item->save();
        }
        $this->messageManager->addSuccess(__('Menu Item saved succesfully.'));
        return $resultRedirect->setPath('*/*/');
    }

}
