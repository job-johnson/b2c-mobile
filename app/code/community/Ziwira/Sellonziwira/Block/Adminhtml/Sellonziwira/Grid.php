<?php

class Ziwira_Sellonziwira_Block_Adminhtml_Sellonziwira_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("sellonziwiraGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("sellonziwira/sellonziwira")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("sellonziwira")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));

				$this->addColumn("merchant_name", array(
				"header" => Mage::helper("sellonziwira")->__("Merchant name"),
				"index" => "merchant_name",
				));
				$this->addColumn("mobile", array(
				"header" => Mage::helper("sellonziwira")->__("Mobile"),
				"index" => "mobile",
				));
				$this->addColumn("owner_name", array(
				"header" => Mage::helper("sellonziwira")->__("Owner Name"),
				"index" => "owner_name",
				));
				$this->addColumn("typeof_product", array(
				"header" => Mage::helper("sellonziwira")->__("Type of Product"),
				"index" => "typeof_product",
				));
				$this->addColumn("compnany_name", array(
				"header" => Mage::helper("sellonziwira")->__("Company Name"),
				"index" => "compnany_name",
				));
				$this->addColumn("typeof_business", array(
				"header" => Mage::helper("sellonziwira")->__("Type Of Business"),
				"index" => "typeof_business",
				));
				$this->addColumn("website_url", array(
				"header" => Mage::helper("sellonziwira")->__("Website Url"),
				"index" => "website_url",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("sellonziwira")->__("Email"),
				"index" => "email",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return '';//$this->getUrl("*/*/edit", array("id" => $row->getId()));
		}



		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_sellonziwira', array(
					 'label'=> Mage::helper('sellonziwira')->__('Remove Sellonziwira'),
					 'url'  => $this->getUrl('*/adminhtml_sellonziwira/massRemove'),
					 'confirm' => Mage::helper('sellonziwira')->__('Are you sure?')
				));
			return $this;
		}


}
