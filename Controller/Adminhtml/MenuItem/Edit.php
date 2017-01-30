<?php
 
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
use Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
class Edit extends MenuItem
{
   /**
     * @return void
     */
   public function execute()
   {
      $menuItemId = $this->getRequest()->getParam('id');
        /** @var \Sahir\MegaMenu\Model\MenuItem $model */
        $model = $this->_menuItemFactory->create();
 
        if ($menuItemId) {
            $model->load($menuItemId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This menu item no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
 
        // Restore previously entered form data from session
        $data = $this->_session->getMenuItemData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('megamenu_menuitem', $model);
 
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Sahir_MegaMenu::main_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Menu Item'));
 
        return $resultPage;
   }
}
