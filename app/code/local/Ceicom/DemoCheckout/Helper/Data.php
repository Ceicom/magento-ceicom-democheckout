<?php
class Ceicom_DemoCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getActivePaymentMethods()
    {        
        foreach (Mage::getSingleton('payment/config')->getActiveMethods() as $paymentMethod) {
            if ($paymentMethod->canUseCheckout()) {
                $activePaymentMethods[$paymentMethod->getCode()] = $paymentMethod->getTitle();
            }
        }

        return $activePaymentMethods;
    }

    public function getPaymentMethodsByCustomerGroup()
    {
        $activePaymentMethods = $this->getActivePaymentMethods();

        foreach ($activePaymentMethods as $paymentMethodCode => $paymentMethodTitle) {
            $paymentMethodsByCustomerGroup[$paymentMethodCode] = $this->getConfig('payment_methods_by_customer_group/' . $paymentMethodCode);
        }

        return $paymentMethodsByCustomerGroup;
    }

    public static function getConfig($path)
    {
        if ($path) {
            return Mage::getStoreConfig('ceicom_democheckout/' . $path);
        }
    }
}