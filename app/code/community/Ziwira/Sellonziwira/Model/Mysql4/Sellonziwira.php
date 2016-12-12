<?php
class Ziwira_Sellonziwira_Model_Mysql4_Sellonziwira extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("sellonziwira/sellonziwira", "id");
    }
}