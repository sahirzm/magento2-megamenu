<?php
 
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
use Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
class Save extends MenuItem
{
   /**
     * @return void
     */
   public function execute()
   {
      $isPost = $this->getRequest()->getPost();
 
      if ($isPost) {
         $menuItemModel = $this->_menuItemFactory->create();
         $menuItemId = $this->getRequest()->getParam('id');
 
         if ($menuItemId) {
            $menuItemModel->load($menuItemId);
         }
         $formData = $this->getRequest()->getParam('menuItem');
         $menuItemModel->setData($formData);
         
         try {
            // Save menuItem 
            $menuItemModel->save();
 
            // Display success message
            $this->messageManager->addSuccess(__('The menuItem has been saved.'));
 
            // Check if 'Save and Continue'
            if ($this->getRequest()->getParam('back')) {
               $this->_redirect('*/*/edit', ['id' => $menuItemModel->getId(), '_current' => true]);
               return;
            }
 
            // Go to grid page
            $this->_redirect('*/*/');
            return;
         } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
         }
 
         $this->_getSession()->setFormData($formData);
         $this->_redirect('*/*/edit', ['id' => $menuItemId]);
      }
   }
}
 
