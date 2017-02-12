<?php
namespace Sahir\MegaMenu\Model\MenuItem;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    protected $_coreRegistry;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Sahir\MegaMenu\Model\ResourceModel\MenuItem\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->_coreRegistry = $registry;
    }

    public function getData() {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach($items as $menuitem) {
            $this->_loadedData[$menuitem->getId()] = $menuitem->getData();
        }

        return $this->_loadedData;
    }
}
