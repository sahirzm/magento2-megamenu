<?php
namespace Sahir\MegaMenu\Api\Data;

interface MenuItemInterface {
    const ENTITY_ID = 'menuitem_id';

    public function getId();

    public function setId($id);
}
?>
