<?php
/**
 * Helcim Gateway object class
 *
 * Removes the auto-underscoring of variable names
 *
 */
class Mage_HelcimGateway_Model_Object extends Varien_Object
{
    public function __call($method, $args)
    {
        switch (substr($method, 0, 3)) {
            case 'get' :
                $key = substr($method,3);
                $data = $this->getData($key, isset($args[0]) ? $args[0] : null);
                return $data;

            case 'set' :
                $key = substr($method,3);
                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
                return $result;

            case 'uns' :
                $key = substr($method,3);
                $result = $this->unsetData($key);
                return $result;

            case 'has' :
                $key = substr($method,3);
                return isset($this->_data[$key]);
			
			default:
				return parent::__call($method, $args);
        }

        throw new Varien_Exception("Invalid method ".get_class($this)."::".$method."(".print_r($args,1).")");
    }
}