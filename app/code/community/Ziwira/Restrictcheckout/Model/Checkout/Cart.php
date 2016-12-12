<?php
class Ziwira_Restrictcheckout_Model_Checkout_Cart extends Mage_Checkout_Model_Cart{
  public function addProduct($productInfo, $requestInfo=null)
  {
    //$pursource ='PURESOURCE';
    //$pra = 'PRA';
    $sku = $productInfo->getSku();
    $explodeSku = explode("-",$sku);
    $changedSku = $explodeSku[1];
    $quoteItems = Mage::getSingleton('checkout/cart')->getQuote()->getItemsCollection();
    $quoteData = $quoteItems->getData();
if(!empty($quoteData)){
  $data= $quoteData[0];
  $sku = explode("-",$data['sku']);
  if($sku[1] !== $changedSku){
//Mage::throwException(Mage::helper('checkout')->__('Cannot add two products from different supplier.'));
Mage::getSingleton('core/session')->addError('Cannot add two products from different supplier.');
//$this->_redirect('checkout/cart');
//Mage::getSingleton('core/session')->addError($this->__('not available'));


  }
  else{
    $product = $this->_getProduct($productInfo);
    $request = $this->_getProductRequest($requestInfo);

    $productId = $product->getId();

    if ($product->getStockItem()) {
        $minimumQty = $product->getStockItem()->getMinSaleQty();
        //If product was not found in cart and there is set minimal qty for it
        if ($minimumQty && $minimumQty > 0 && $request->getQty() < $minimumQty
            && !$this->getQuote()->hasProductId($productId)
        ){
            $request->setQty($minimumQty);
        }
    }

    if ($productId) {
        try {
            $result = $this->getQuote()->addProduct($product, $request);
        } catch (Mage_Core_Exception $e) {
            $this->getCheckoutSession()->setUseNotice(false);
            $result = $e->getMessage();
        }
        /**
         * String we can get if prepare process has error
         */
        if (is_string($result)) {
            $redirectUrl = ($product->hasOptionsValidationFail())
                ? $product->getUrlModel()->getUrl(
                    $product,
                    array('_query' => array('startcustomization' => 1))
                )
                : $product->getProductUrl();
            $this->getCheckoutSession()->setRedirectUrl($redirectUrl);
            if ($this->getCheckoutSession()->getUseNotice() === null) {
                $this->getCheckoutSession()->setUseNotice(true);
            }
            Mage::throwException($result);
        }
    } else {
        Mage::throwException(Mage::helper('checkout')->__('The product does not exist.'));
    }

    Mage::dispatchEvent('checkout_cart_product_add_after', array('quote_item' => $result, 'product' => $product));
    $this->getCheckoutSession()->setLastAddedProductId($productId);
    return $this;
   }
 }
   else{
     $product = $this->_getProduct($productInfo);
     $request = $this->_getProductRequest($requestInfo);

     $productId = $product->getId();

     if ($product->getStockItem()) {
         $minimumQty = $product->getStockItem()->getMinSaleQty();
         //If product was not found in cart and there is set minimal qty for it
         if ($minimumQty && $minimumQty > 0 && $request->getQty() < $minimumQty
             && !$this->getQuote()->hasProductId($productId)
         ){
             $request->setQty($minimumQty);
         }
     }

     if ($productId) {
         try {
             $result = $this->getQuote()->addProduct($product, $request);
         } catch (Mage_Core_Exception $e) {
             $this->getCheckoutSession()->setUseNotice(false);
             $result = $e->getMessage();
         }
         /**
          * String we can get if prepare process has error
          */
         if (is_string($result)) {
             $redirectUrl = ($product->hasOptionsValidationFail())
                 ? $product->getUrlModel()->getUrl(
                     $product,
                     array('_query' => array('startcustomization' => 1))
                 )
                 : $product->getProductUrl();
             $this->getCheckoutSession()->setRedirectUrl($redirectUrl);
             if ($this->getCheckoutSession()->getUseNotice() === null) {
                 $this->getCheckoutSession()->setUseNotice(true);
             }
             Mage::throwException($result);
         }
     } else {
         Mage::throwException(Mage::helper('checkout')->__('The product does not exist.'));
     }

     Mage::dispatchEvent('checkout_cart_product_add_after', array('quote_item' => $result, 'product' => $product));
     $this->getCheckoutSession()->setLastAddedProductId($productId);
     return $this;
   }
  }
}
