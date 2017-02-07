<?php
namespace Sahir\MegaMenu\Ui\Component\Listing\DataProviders\Sahir\Megamenu;

class Menulist extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Sahir\MegaMenu\Model\ResourceModel\MenuItem\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

}
