<?php
class Ceicom_DemoCheckout_Block_Multiselectgroup extends Mage_Adminhtml_Block_System_Config_Form_Field
{

     protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {

        $paymentMethods = $this->getActivPaymentMethods();
        $elementHtml = '';

        foreach ($paymentMethods as $paymentCod => $payment) {
            $multiselect = new Varien_Data_Form_Element_Multiselect($element->getData());
            $input = new Varien_Data_Form_Element_Hidden($element->getData());
            $value = Mage::getStoreConfig("democheckout/democheckout_payment/method_{$payment['value']}");

            $input->setName("groups[democheckout_payment][fields][method_{$payment['value']}][value]");
            $multiselect->setName("groups[democheckout_payment][fields][method_{$payment['value']}][value][]");
            $multiselect->setValue($value);
            $multiselect->setSelected($value);
            $multiselect->setForm($element->getForm());
            $input->setForm($element->getForm());

            $elementHtml .= $input->getElementHtml() . sprintf(
                '<br><label for="%s"><b>%s</b></label><br>',
                $element->getHtmlId(), $payment['label']
            ) . $multiselect->getElementHtml();

        }

        return $elementHtml;
    }

    protected function getActivPaymentMethods()
    {

        $payments = Mage::getSingleton('payment/config')->getActiveMethods();
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $store = $quote ? $quote->getStoreId() : null;

        foreach (Mage::helper('payment')->getStoreMethods($store, $quote) as $method) {
            if ( $method->canUseCheckout() && $method->getCode() != 'free') {
                $paymentTitle = Mage::getStoreConfig("payment/{$method->getCode()}/title");
                $methods[$method->getCode()] = array(
                    'label'   => $paymentTitle,
                    'value' => $method->getCode(),
                );
            }
        }

        return $methods;
    }

}