<?php
class Ziwira_Sellonziwira_Block_Adminhtml_Sellonziwira_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("sellonziwira_form", array("legend"=>Mage::helper("sellonziwira")->__("Item information")));

				
						$fieldset->addField("merchant_name", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Merchant name"),
						"name" => "merchant_name",
						));
					
						$fieldset->addField("mobile", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Mobile"),
						"name" => "mobile",
						));
					
						$fieldset->addField("owner_name", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Owner Name"),
						"name" => "owner_name",
						));
					
						$fieldset->addField("typeof_product", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Type of Product"),
						"name" => "typeof_product",
						));
					
						$fieldset->addField("compnany_name", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Company Name"),
						"name" => "compnany_name",
						));
					
						$fieldset->addField("typeof_business", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Type Of Business"),
						"name" => "typeof_business",
						));
					
						$fieldset->addField("website_url", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Website Url"),
						"name" => "website_url",
						));
					
						$fieldset->addField("business_desc", "textarea", array(
						"label" => Mage::helper("sellonziwira")->__("Business Description"),
						"name" => "business_desc",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("sellonziwira")->__("Email"),
						"name" => "email",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getSellonziwiraData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getSellonziwiraData());
					Mage::getSingleton("adminhtml/session")->setSellonziwiraData(null);
				} 
				elseif(Mage::registry("sellonziwira_data")) {
				    $form->setValues(Mage::registry("sellonziwira_data")->getData());
				}
				return parent::_prepareForm();
		}
}
