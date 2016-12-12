<?php
class Ziwira_Sellonziwira_Block_Adminhtml_Sellonziwira_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("sellonziwira_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("sellonziwira")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("sellonziwira")->__("Item Information"),
				"title" => Mage::helper("sellonziwira")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("sellonziwira/adminhtml_sellonziwira_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
