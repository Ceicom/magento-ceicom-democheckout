<?php
class Ceicom_DemoCheckout_Model_Observer
{
	protected $_paymentMethodsByCustomerGroup;

	public function paymentMethodIsActive($observer)
	{
		$result = $observer->getResult();
		$methodInstance = $observer->getMethodInstance();

		if ($result->isAvailable && $methodInstance->canUseCheckout()) {
			$quote = $observer->getQuote();
			$paymentMethodsByCustomerGroup = $this->_getPaymentMethodsByCustomerGroup();
			$customerGroupsAllowed = $paymentMethodsByCustomerGroup[$methodInstance->getCode()];

			if (!$customerGroupsAllowed) {
				return;
			}

			if (!in_array($quote->getCustomerGroupId(), explode(',', $customerGroupsAllowed))) {
				$result->isAvailable = false;
			}
		}
	}

	public function customerIsAbleToPlaceOrder($observer)
	{
		$quote = $observer->getQuote();
		$demoCheckoutEnabledByCustomerGroup = $this->_getHelper()->getConfig('general/enabled_by_customer_group');

		if (!$demoCheckoutEnabledByCustomerGroup || in_array($quote->getCustomerGroupId(), explode(',', $demoCheckoutEnabledByCustomerGroup))) {
			Mage::throwException($this->_getHelper()->getConfig('general/message'));
		}
	}

	protected function _getPaymentMethodsByCustomerGroup()
	{
		if (empty($this->_paymentMethodsByCustomerGroup)) {
			$this->_paymentMethodsByCustomerGroup = $this->_getHelper()->getPaymentMethodsByCustomerGroup();
		}

		return $this->_paymentMethodsByCustomerGroup;
	}

	protected function _getHelper()
	{
		return Mage::helper('ceicom_democheckout');
	}
}