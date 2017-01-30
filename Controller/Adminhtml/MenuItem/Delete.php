<?php
 
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
use Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
class Delete extends MenuItem 
{
   /**
    * @return void
    */
   public function execute()
   {
      $menuItemId = (int) $this->getRequest()->getParam('id');
 
      if ($menuItemId) {
         /** @var $menuItemModel \Sahir\MegaMenu\Model\MenuItem */
         $menuItemModel = $this->_menuItemFactory->create();
         $menuItemModel->load($menuItemId);
 
         // Check this menuItem exists or not
         if (!$menuItemModel->getId()) {
            $this->messageManager->addError(__('This menuItem no longer exists.'));
         } else {
               try {
                  // DeletemenuItem 
                  $menuItemModel->delete();
                  $this->messageManager->addSuccess(__('The menuItem has been deleted.'));
 
                  // Redirect to grid page
                  $this->_redirect('*/*/');
                  return;
               } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->_redirect('*/*/edit', ['id' => $menuItemModel->getId()]);
               }
            }
      }
   }
}
