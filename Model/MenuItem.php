<?php
namespace Sahir\MegaMenu\Model;
class MenuItem extends \Magento\Framework\Model\AbstractModel implements MenuItemInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'sahir_megamenu_menuitem';

    protected function _construct()
    {
        $this->_init('Sahir\MegaMenu\Model\ResourceModel\MenuItem');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
