<?php
class Ziwira_Emptycart_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      //Get cart helper
      		$cartHelper = Mage::helper('checkout/cart');

      		//Get all items from cart
      		$items = $cartHelper->getCart()->getItems();

      		//Loop through all of cart items
      		foreach ($items as $item) {
      			$itemId = $item->getItemId();
      			//Remove items, one by one
      			$cartHelper->getCart()->removeItem($itemId)->save();
      		}

      		//Redirect back to cart or wherever you wish
      		$this->_redirect('checkout/cart');
          
    }
}
