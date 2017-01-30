<?php
 
namespace Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
use Sahir\MegaMenu\Controller\Adminhtml\MenuItem;
 
class Create extends MenuItem
{
   /**
     * Create new menu item action
     *
     * @return void
     */
   public function execute()
   {
      $this->_forward('edit');
   }
}
