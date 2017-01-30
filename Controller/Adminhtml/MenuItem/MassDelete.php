<?php
 
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
use Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
class MassDelete extends MenuItem 
{
   /**
    * @return void
    */
   public function execute()
   {
      // Get IDs of the selectedmenuItem 
      $menuItemIds = $this->getRequest()->getParam('menuItem');
 
        foreach ($menuItemIds as $menuItemId) {
            try {
               /** @var $menuItemModel \Sahir\MegaMenu\Model\MenuItem */
                $menuItemModel = $this->_menuItemFactory->create();
                $menuItemModel->load($menuItemId)->delete();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
 
        if (count($menuItemIds)) {
            $this->messageManager->addSuccess(
                __('A total of %1 record(s) were deleted.', count($menuItemIds))
            );
        }
 
        $this->_redirect('*/*/index');
   }
}
