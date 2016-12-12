<?php
class Ziwira_Sellonziwira_Adminhtml_SellonziwirabackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Sell On Ziwira"));
	   $this->renderLayout();
    }
}