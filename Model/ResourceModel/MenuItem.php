<?php
namespace Sahir\MegaMenu\Model\ResourceModel;
class MenuItem extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('sahir_megamenu_menuitem','menuitem_id');
    }
}
