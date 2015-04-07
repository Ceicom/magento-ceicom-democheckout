<?php
class Ceicom_DemoCheckout_Block_Multiselectgroup extends Mage_Adminhtml_Block_System_Config_Form_Field
{

     protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($multiselect);
        $paymentMethods = $this->getActivPaymentMethods();
        $elementHtml = '';

        foreach ($paymentMethods as $paymentCod => $payment) {
            $multiselect = new Varien_Data_Form_Element_Multiselect($element->getData());
            $multiselect->setName("groups[democheckout_payment][fields][method_{$payment['value']}][value][]");
            $value = Mage::getStoreConfig("democheckout/democheckout_payment/method_{$payment['value']}");
            $multiselect->setValue($value);
            $multiselect->setForm($element->getForm());
            $elementHtml .= sprintf(
                '<br><label for="%s"><b>%s</b></label><br>',
                $element->getHtmlId(), $payment['label']
            ) . $multiselect->getElementHtml();
        }

        return $elementHtml;
    }

    protected function getActivPaymentMethods()
    {

        $payments = Mage::getSingleton('payment/config')->getActiveMethods();

        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = array(
                'label'   => $paymentTitle,
                'value' => $paymentCode,
            );
        }

        return $methods;
    }

}