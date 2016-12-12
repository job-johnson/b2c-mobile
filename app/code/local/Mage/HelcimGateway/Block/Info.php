<?php
/**
 * Helcim Gateway info class
 */

class Mage_HelcimGateway_Block_Info extends Mage_Payment_Block_Info
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('helcimgateway/info.phtml');
	}

	public function getExpiryDate()
	{
		return sprintf('%02d', $this->getInfo()->getCcExpMonth()).'/'.sprintf('%02d', $this->getInfo()->getCcExpYear());
	}
}