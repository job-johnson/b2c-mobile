<?php


class Ziwira_Sellonziwira_Block_Adminhtml_Sellonziwira extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_sellonziwira";
	$this->_blockGroup = "sellonziwira";
	$this->_headerText = Mage::helper("sellonziwira")->__("Sellonziwira Manager");
	//$this->_addButtonLabel = Mage::helper("sellonziwira")->__("Add New Item");
	parent::__construct();
	$this->_removeButton('add');

	}

}
