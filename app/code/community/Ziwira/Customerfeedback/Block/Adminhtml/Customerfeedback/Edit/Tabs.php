<?php
class Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("customerfeedback_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("customerfeedback")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("customerfeedback")->__("Item Information"),
				"title" => Mage::helper("customerfeedback")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("customerfeedback/adminhtml_customerfeedback_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
