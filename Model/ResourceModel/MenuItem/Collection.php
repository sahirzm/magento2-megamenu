<?php
namespace Sahir\MegaMenu\Model\ResourceModel\MenuItem;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Sahir\MegaMenu\Model\MenuItem','Sahir\MegaMenu\Model\ResourceModel\MenuItem');
    }
}
