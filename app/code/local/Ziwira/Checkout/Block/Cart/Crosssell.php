<!--
Author Name: Firasath
Author URI: http://www.firasath.com
Author Email: firasath_hussain20@yahoo.com
-->
<?php

class Ziwira_Checkout_Block_Cart_Crosssell extends Mage_Checkout_Block_Cart_Crosssell
{
    public function setMaxItems($value = 5)
    {
        $this->_maxItemCount = $value;
    }
}

 ?>
