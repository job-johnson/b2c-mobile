<?php


class Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_customerfeedback";
	$this->_blockGroup = "customerfeedback";
	$this->_headerText = Mage::helper("customerfeedback")->__("Customerfeedback Manager");
	$this->_addButtonLabel = Mage::helper("customerfeedback")->__("Add New Item");
	parent::__construct();
	
	}

}