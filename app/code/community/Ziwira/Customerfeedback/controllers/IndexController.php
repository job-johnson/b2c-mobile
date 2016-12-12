<?php
class Ziwira_Customerfeedback_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Customer Feedback"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("customer feedback", array(
                "label" => $this->__("Customer Feedback"),
                "title" => $this->__("Customer Feedback")
		   ));

      $this->renderLayout();

    }

    public function SaveAction(){

      $customerName = $this->getRequest()->getParam('customer-name');
      $feedbackDesc = $this->getRequest()->getParam('feedback-desc');
      if($customerName !='' && $feedbackDesc !=''){
      $model = Mage::getModel('customerfeedback/customerfeedback');
      $model->setCustomerName($customerName);
      $model->setFeedback($feedbackDesc);
      $model->setPostedDate(date("Y-m-d h:i:sa"));
      $model->setApproved(0);
      $save = $model->save();
      if($save->isObjectNew())
      {

      Mage::getSingleton('core/session')->addSuccess('Thanks for you feedback.');
      $this->_redirect('*/*/');

      }
    else{
      Mage::getSingleton('core/session')->addSuccess('Unanle to save data.');
      $this->_redirect('*/*/');

    }
    }
    else{
      Mage::getSingleton('core/session')->addSuccess('Insert Required data.');
      $this->_redirect('*/*/');
    }
    }
}
