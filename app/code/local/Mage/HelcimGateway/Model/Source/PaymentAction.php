<?php
/**
 * Helcim Gateway model source class
 */
class Mage_HelcimGateway_Model_Source_PaymentAction
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Mage_HelcimGateway_Model_PaymentMethod::ACTION_AUTHORIZE_CAPTURE, 
                'label' => Mage::helper('helcimgateway')->__('Authorize and Capture')
            )
        );
    }
}
?>