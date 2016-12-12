<?php
class Ziwira_Customerfeedback_Model_Mysql4_Customerfeedback extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("customerfeedback/customerfeedback", "id");
    }
}