<?php
/**
 * Helcim Gateway block class
 */
class Mage_HelcimGateway_Block_Form extends Mage_Payment_Block_Form
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('helcimgateway/form.phtml');		
	}
}