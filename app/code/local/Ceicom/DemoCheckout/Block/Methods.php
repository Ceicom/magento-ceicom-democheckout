<?php
class Ceicom_DemoCheckout_Block_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{

    public function getMethods()
    {
        $customer = Mage::getSingleton('customer/session');
        $user_id = $customer->getId();
        $methods = $this->getData('methods');

        if ($methods === null) {
            $quote = $this->getQuote();
            $store = $quote ? $quote->getStoreId() : null;
            $methods = array();

            foreach ($this->helper('payment')->getStoreMethods($store, $quote) as $method) {
                $valueFuck = Mage::getStoreConfig("democheckout/democheckout_payment/method_{$method->getCode()}");
                $valuesHaha = explode(',',$valueFuck);

                if (in_array($user_id, $valuesHaha)) {
                    if ($this->_canUseMethod($method) && $method->isApplicableToQuote(
                        $quote,
                        Mage_Payment_Model_Method_Abstract::CHECK_ZERO_TOTAL
                    )) {
                        $this->_assignMethod($method);
                        $methods[] = $method;
                    }
                }
            }

            $this->setData('methods', $methods);
        }

        return $methods;
    }

}
