<?php
class Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("customerfeedback_form", array("legend"=>Mage::helper("customerfeedback")->__("Item information")));

				
						$fieldset->addField("customer_name", "text", array(
						"label" => Mage::helper("customerfeedback")->__("Customer Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "customer_name",
						));
					
						$fieldset->addField("feedback", "textarea", array(
						"label" => Mage::helper("customerfeedback")->__("Customer Feedback"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "feedback",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('posted_date', 'date', array(
						'label'        => Mage::helper('customerfeedback')->__('Posted Date'),
						'name'         => 'posted_date',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));				
						 $fieldset->addField('approved', 'select', array(
						'label'     => Mage::helper('customerfeedback')->__('Approved'),
						'values'   => Ziwira_Customerfeedback_Block_Adminhtml_Customerfeedback_Grid::getValueArray3(),
						'name' => 'approved',					
						"class" => "required-entry",
						"required" => true,
						));

				if (Mage::getSingleton("adminhtml/session")->getCustomerfeedbackData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getCustomerfeedbackData());
					Mage::getSingleton("adminhtml/session")->setCustomerfeedbackData(null);
				} 
				elseif(Mage::registry("customerfeedback_data")) {
				    $form->setValues(Mage::registry("customerfeedback_data")->getData());
				}
				return parent::_prepareForm();
		}
}
