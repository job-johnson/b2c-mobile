<?php
/**
 * Helcim Gateway payment module
 */

class Mage_HelcimGateway_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
	protected $_code = 'helcimgateway';
	protected $_formBlockType = 'helcimgateway/form';
	protected $_infoBlockType = 'helcimgateway/info';

	/**
	 * Availability options
	 */
	
	protected $_isGateway = true;
	protected $_canAuthorize = false;
	protected $_canCapture = true;
	protected $_canCapturePartial = false;
	protected $_canRefund = false;
	protected $_canVoid = false;
	protected $_canUseInternal = true;
	protected $_canUseCheckout = true;
	protected $_canUseForMultiShipping = true;
	protected $_canSaveCc = false;
	
	public function assignData($data)
	{
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
		parent::assignData($data);
        $info = $this->getInfoInstance();
        $info
            ->setCcOwner($data->getCcOwner())
            ->setCcLast4(substr($data->getCcNumber(), -4))
            ->setCcNumber($data->getCcNumber())
            ->setCcCid($data->getCcCid())
            ->setCcExpMonth($data->getCcExpMonth())
            ->setCcExpYear($data->getCcExpYear());
        return $this;
	}

	public function capture(Varien_Object $payment, $amount)
	{
		$error = false;
		
		$payment->setTransactionType('purchase');

		$request = $this->generateRequest($payment, $amount);
		$result  = $this->sendRequest($request);
		
		if ($result->getresponse() != 1)
		{
			$error = Mage::helper('helcimgateway')->__($result->getresponseMessage());
		}
		else
		{
			$payment
				->setCcStatus('APPROVED')
				->setGatewayOrderId($result->getorderId())
				->setCcTransId($result->gettransactionId())
				->setCcAvsStatus($result->getavsResponse())
				->setCcCidStatus($result->getcvvResponse());
		}

		if ($error !== false)
			Mage::throwException($error);

		return $this;
	}
	
	protected function generateRequest(Varien_Object $payment, $amount)
	{
		$request = new Mage_HelcimGateway_Model_Object();

		$order = $payment->getOrder();
		$billing = $order->getBillingAddress();
		$shipping = $order->getShippingAddress();
		
		// Required info
		$request
			->setmerchantId($this->getConfigData('merchant_id'))
			->settoken($this->getConfigData('gateway_token'))
			->settype($payment->getTransactionType())
			->setamount(number_format($amount,2,'.',''))
			->setcardNumber($payment->getcc_number())
			->setexpiryDate(sprintf('%02d', $payment->getcc_exp_month()).sprintf('%02d', $payment->getcc_exp_year()))
			->setcardholderName($payment->getcc_owner())
			->setcardholderAddress($billing->getStreet(1))
			->setcardholderPostalCode($billing->getPostcode())
			->settest($this->getConfigData('test_mode'));
		
		// Optional info (can be removed)
		// Billing
		$request
			->setbillingName($billing->getFirstname().' '.$billing->getLastname())
			->setbillingAddress($billing->getStreet(1))
			->setbillingCity($billing->getCity())
			->setbillingProvince($billing->getRegion())
			->setbillingPostalCode($billing->getPostcode())
			->setbillingCountry($billing->getCountry())
			->setbillingPhoneNumber($billing->getTelephone())
			->setbillingEmailAddress($order->getCustomerEmail());
		// Shipping	
		$request
			->setshippingName($shipping->getFirstname().' '.$shipping->getLastname())
			->setshippingAddress($shipping->getStreet(1))
			->setshippingCity($shipping->getCity())
			->setshippingProvince($shipping->getRegion())
			->setshippingPostalCode($shipping->getPostcode())
			->setshippingCountry($shipping->getCountry())
			->setshippingPhoneNumber($shipping->getTelephone());
		// Order
		$request
			->setcustomerId($order->getCustomerId())
			->setshippingAmount(number_format($order->getShippingAmount(), 2, '.', ''))
			->settaxAmount(number_format($order->getTaxAmount(), 2, '.', ''));
		
		// Items
		$checkout = Mage::getSingleton('checkout/session');
		$quote = $checkout->getQuote();
		$items = $quote->getAllItems();
		
		$i = 1;
		foreach ($items as $item)
		{			
			$request
				->setData('itemId'.$i, $item->getSku())
				->setData('itemDescription'.$i, $item->getName())
				->setData('itemQuantity'.$i, $item->getQty())
				->setData('itemPrice'.$i, $item->getCalculationPrice())
				->setData('itemTotal'.$i, number_format($item->getRowTotal(), 2, '.', ''));
			$i++;
		}
		
		if ($this->getConfigData('disable_cvv'))
		{
			$request->setcvvIndicator('4');
		}
		else
		{
			$request->setcvvIndicator('1')
					->setcvv($payment->getcc_cid());
		}

		return $request;
	}
	
	protected function sendRequest(Varien_Object $request)
	{
		$result = new Mage_HelcimGateway_Model_Object();

		$http = new Varien_Http_Client();

		$http->setUri($this->getConfigData('gateway_url'))
			 ->setConfig(array( 'maxredirects' => 0, 'timeout' => 30 ))
			 ->setParameterPost($request->getData())
			 ->setMethod(Zend_Http_Client::POST);
		try
		{
			$response = $http->request();
		}
		catch (Exception $e)
		{
			Mage::throwException(Mage::helper('helcimgateway')->__('Communication error: %s', $e->getMessage()));
		}

		$responseBody = preg_replace('/\x0D\x0A/','&',$response->getBody());
		parse_str($responseBody, $responseArray);
		
		$result->setData($responseArray);
		return $result;
	}

	public function validate()
	{
		$error = false;

		if ($error !== false)
			Mage::throwException($error);

		return $this;
	}

	public function cvvDisabled()
	{
		return $this->getConfigData('disable_cvv');
	}

	public function getExpiryMonths()
	{
		return array('Month', '01 - January', '02 - February', '03 - March', '04 - April', '05 - May', '06 - June', '07 - July', '08 - August', '09 - September', '10 - October', '11 - November', '12 - December');
	}

	public function getExpiryYears()
	{
		$currentDate = date_create();
		$currentYear = $currentDate->format('y');
		$yearsArray = array('Year');
		for ($i = $currentYear; $i != $currentYear+10; $i++)
		{
			$yearsArray[$currentDate->format('y')] = $currentDate->format('Y');
			$currentDate->modify('+1 year');			
		}
		return $yearsArray;
	}
}