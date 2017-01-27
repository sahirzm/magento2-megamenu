<?php
namespace Sahir\MegaMenu\Api;

use Sahir\MegaMenu\Model\MenuItemInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface MenuItemRepositoryInterface 
{
    public function save(MenuItemInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(MenuItemInterface $page);

    public function deleteById($id);
}
