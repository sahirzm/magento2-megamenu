<?php

namespace Sahir\MegaMenu\Block;

class MegaMenu extends \Magento\Framework\View\Element\Template {

    protected $_menuItemFactory;

    protected $_categoryFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sahir\MegaMenu\Model\MenuItemFactory $menuItemFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory
    ) {
        parent::__construct($context);
        $this->_menuItemFactory = $menuItemFactory;
        $this->_categoryFactory = $categoryFactory;
    }

    public function getHtml() {
        $menuItems = $this->_menuItemFactory->create()->getCollection()->addFilter('is_active', true);
        $html = "";
        foreach ($menuItems as $mi) {
            if ($mi->getMenuItemType() == 0) {
                $category = $this->_categoryFactory->create()->load($mi->getCategoryId());
                if ($category == NULL) {
                    die("category is null. category_id = " . $mi->getCategoryId());
                }
                $megamenu = $category->hasChildren();
                $filterAttr = $mi->getFilterAttributes();
                $html .= '<li class="'. ($megamenu ? 'has-mega-menu' : '') .'"><a href="' . $category->getUrl()
                    . ($filterAttr != '' ? '?' . $filterAttr : '')
                    . '">' . $mi->getMenuItemText() . '</a>'
                    . ($megamenu ? $this->_subMenu($category, $filterAttr) : '')
                    . '</li>';
            } else if($mi->getMenuItemType() == 1) {
                $html .= '<li><a href="' . $mi->getUrl() . '">' . $mi->getMenuItemText() . '</a></li>';
            }
        }
        return $html;
    }

    protected function _subMenu($category, $filterAttr) {
        $html = '<ul class="mega-menu">';
        foreach(explode(',', $category->getChildren()) as $child) {
            $childCategory = $this->_categoryFactory->create()->load($child);
            $html .= '<li><div class="mega-menu-container"><a href="'. $childCategory->getUrl()
                . ($filterAttr != '' ? '?' . $filterAttr : '')
                .'">' . $childCategory->getName() . '</a>';
            if ($childCategory->hasChildren()) {
                $html .= $this->_subMenuList($childCategory, $filterAttr);
            }
            $html .= '</div></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    protected function _subMenuList($category, $filterAttr) {
        $html = '<ul class="sub-menu">';
        foreach(explode(',', $category->getChildren()) as $child) {
            $childCategory = $this->_categoryFactory->create()->load($child);
            $html .= '<li><a href="'. $childCategory->getUrl()
                . ($filterAttr != '' ? '?' . $filterAttr : '')
                .'">' . $childCategory->getName() . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

}
?>
