<?php

class Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("customerfeedbackGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("customerfeedback/customerfeedback")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("customerfeedback")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));

				$this->addColumn("customer_name", array(
				"header" => Mage::helper("customerfeedback")->__("Customer Name"),
				"index" => "customer_name",
				));
					$this->addColumn('posted_date', array(
						'header'    => Mage::helper('customerfeedback')->__('Posted Date'),
						'index'     => 'posted_date',
						'type'      => 'datetime',
					));
						$this->addColumn('approved', array(
						'header' => Mage::helper('customerfeedback')->__('Approved'),
						'index' => 'approved',
						'type' => 'options',
						'options'=>Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Grid::getOptionArray3(),
						));

			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}



		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_customerfeedback', array(
					 'label'=> Mage::helper('customerfeedback')->__('Remove Customerfeedback'),
					 'url'  => $this->getUrl('*/adminhtml_customerfeedback/massRemove'),
					 'confirm' => Mage::helper('customerfeedback')->__('Are you sure?')
				));
			return $this;
		}

		static public function getOptionArray3()
		{
            $data_array=array();
			$data_array[1]='Yes';
			$data_array[0]='No';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);
			}
            return($data_array);

		}


}
