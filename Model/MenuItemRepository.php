<?php
namespace Sahir\MegaMenu\Model;

use Sahir\MegaMenu\Api\MenuItemRepositoryInterface;
use Sahir\MegaMenu\Model\MenuItemInterface;
use Sahir\MegaMenu\Model\MenuItemFactory;
use Sahir\MegaMenu\Model\ResourceModel\MenuItem\CollectionFactory;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class MenuItemRepository implements \Sahir\MegaMenu\Api\MenuItemRepositoryInterface
{
    protected $objectFactory;
    protected $collectionFactory;
    public function __construct(
        MenuItemFactory $objectFactory,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory       
    )
    {
        $this->objectFactory        = $objectFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function save(MenuItemInterface $object)
    {
        try
        {
            $object->save();
        }
        catch(\Exception $e)
        {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $object;
    }

    public function getById($id)
    {
        $object = $this->objectFactory->create();
        $object->load($id);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        return $object;        
    }       

    public function delete(MenuItemInterface $object)
    {
        try {
            $object->delete();
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;    
    }    

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }    

    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);  
        $collection = $this->collectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }  
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $objects = [];                                     
        foreach ($collection as $objectModel) {
            $objects[] = $objectModel;
        }
        $searchResults->setItems($objects);
        return $searchResults;        
    }
}
