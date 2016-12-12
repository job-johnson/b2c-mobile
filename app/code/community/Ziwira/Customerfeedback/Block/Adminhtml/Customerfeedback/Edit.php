<?php
	
class Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "id";
				$this->_blockGroup = "customerfeedback";
				$this->_controller = "adminhtml_customerfeedback";
				$this->_updateButton("save", "label", Mage::helper("customerfeedback")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("customerfeedback")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("customerfeedback")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("customerfeedback_data") && Mage::registry("customerfeedback_data")->getId() ){

				    return Mage::helper("customerfeedback")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("customerfeedback_data")->getId()));

				} 
				else{

				     return Mage::helper("customerfeedback")->__("Add Item");

				}
		}
}