<?php
namespace Sahir\MegaMenu\Block;

use Magento\Framework\View\Element\Template;
use Magento\Theme\Block\Html\TopMenu;

class Main extends TopMenu {

    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0) {
        $html = "";
        foreach ($this->_menu->getChildren() as $child) {
            $html .= "<li>" . $child->getName() . "</li>";
        }
        return $html;
    }
}
?>
