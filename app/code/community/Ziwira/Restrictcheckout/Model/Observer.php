<?php
class Ziwira_Restrictcheckout_Model_Observer
{

			public function BeforeCartSave(Varien_Event_Observer $observer)
			{
			//	Mage::dispatchEvent('checkout_cart_save_before', array('cart'=>$this));
		//		$cart = $observer->getEvent()->getCart();
			//echo "<pre>";
			//print_r($observer->getEvent());
			//	die();
				//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
				//$user = $observer->getEvent()->getUser();
				//$user->doSomething();
			}

}
