<?php
class Ziwira_Sellonziwira_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {

	  $this->loadLayout();
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Sell On Ziwira"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("sell on ziwira", array(
                "label" => $this->__("Sell On Ziwira"),
                "title" => $this->__("Sell On Ziwira")
		   ));

      $this->renderLayout();

    }

public function saveAction(){
    $merchantName = $this->getRequest()->getParam('merhcant-name');
    $ownerName = $this->getRequest()->getParam('owner-name');
    $compnayName = $this->getRequest()->getParam('compnay-name');
    $websiteUrl = $this->getRequest()->getParam('website-url');
    $email = $this->getRequest()->getParam('email');
    $mobile = $this->getRequest()->getParam('mobile');
    $typeofProduct = $this->getRequest()->getParam('typeof-product');
    $typeofBusiness = $this->getRequest()->getParam('typrof-business');
    $businesDesc = $this->getRequest()->getParam('business-desc');
    if($ownerName !=''|| $compnayName !=''|| $email !=''){
    $html.="<p><b>Merchant Name:</b> ".$merchantName."</p><br/>";
    $html.="<p><b>Owner Name:</b> ".$ownerName."</p><br/>";
    $html.="<p><b>Company Name:</b> ".$compnayName."</p><br/>";
    $html.="<p><b>Website Url:</b> ".$websiteUrl."</p><br/>";
    $html.="<p><b>Email:</b> ".$email."</p><br/>";
    $html.="<p><b>Mobile :</b> ".$mobile."</p><br/>";
    $html.="<p><b>Type of product Name:</b> ".$typeofProduct."</p><br/>";
    $html.="<p><b>Type of business:</b> ".$typeofBusiness."</p><br/>";
    $html.="<p><b>Business Description:</b> ".$businesDesc."</p><br/>";
    $mailResponse = $this->senEmailToSeller('merchantsupport@ziwira.com',$html);

//echo "<pre>"; print_r($mailResponse);
    if($mailResponse){
      $model = Mage::getModel('sellonziwira/sellonziwira');
      $model->setMerchantName($merchantName);
      $model->setMobile($mobile);
      $model->setOwnerName($ownerName);
      $model->setTypeofProduct($typeofProduct);
      $model->setCompnanyName($compnayName);
      $model->setTypeofBusiness($typeofBusiness);
      $model->setWebsiteUrl($websiteUrl);
      $model->setBusinessDesc($businesDesc);
      $model->setEmail($email);
      $save = $model->save();

      if($save->isObjectNew())
      {

        Mage::getSingleton('core/session')->addSuccess('Data Saved Successfully shortly our team will contact you.');
        $this->_redirect('*/*/');

      }
    else{
      Mage::getSingleton('core/session')->addSuccess('Unanle to save data.');
    $this->_redirect('*/*/');

    }
    }
  }
  else{
    Mage::getSingleton('core/session')->addSuccess('Insert Required data.');
  $this->_redirect('*/*/');
  }

    }






    public function senEmailToSeller($toEMail,$html){
$mail = Mage::getModel('core/email');
$mail->setToName('Ziwira');
$mail->setToEmail($toEMail);
$mail->setBody($html);
$mail->setSubject('Ziwira Seller Form');
$mail->setFromEmail('noreply@ziwira.com');
$mail->setFromName("Ziwira Seller Form");
$mail->setType('html');// YOu can use Html or text as Mail format

try {
$Emailsent = $mail->send();
Mage::getSingleton('core/session')->addSuccess('Your request has been sent');
//$this->_redirect('');
}
catch (Exception $e) {
Mage::getSingleton('core/session')->addError('Unable to send.');
//$this->_redirect('');
}

return $Emailsent;
}
}
