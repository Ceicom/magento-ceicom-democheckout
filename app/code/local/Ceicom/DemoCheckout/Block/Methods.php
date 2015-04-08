<?php
class Ceicom_DemoCheckout_Block_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{

    public function getMethods()
    {
        $methods = $this->getData('methods');

        if ($methods === null) {
            $quote = $this->getQuote();
            $store = $quote ? $quote->getStoreId() : null;
            $methods = array();

            foreach ($this->helper('payment')->getStoreMethods($store, $quote) as $method) {
                    if ($this->_canUseMethod($method) && $method->isApplicableToQuote(
                        $quote,
                        Mage_Payment_Model_Method_Abstract::CHECK_ZERO_TOTAL
                    ) && $this->methodIsValid($method) ) {
                        $this->_assignMethod($method);
                        $methods[] = $method;
                    }
            }

            $this->setData('methods', $methods);
        }

        return $methods;
    }

    protected function methodIsValid($method)
    {
        $userGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
        $validGroups = Mage::getStoreConfig("democheckout/democheckout_payment/method_{$method->getCode()}");
        $allisValid = in_array('', explode(',', $validGroups));
        $userIsValid = in_array($userGroupId, explode(',', $validGroups));

        return ( $userIsValid || $allisValid );
    }

}
