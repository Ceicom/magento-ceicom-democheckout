<?php
class Ceicom_DemoCheckout_Block_Adminhtml_System_Config_Form_Fieldset_Payment_Customer_Groups
	extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
	protected $_dummyElement;
    protected $_fieldRenderer;
    protected $_values;

	public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);
        $activePaymentMethods = Mage::helper('ceicom_democheckout')->getActivePaymentMethods();

        foreach ($activePaymentMethods as $paymentMethodCode => $paymentMethodTitle) {
        	$html.= $this->_getFieldHtml($element, $paymentMethodCode, $paymentMethodTitle);
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getDummyElement()
    {
        if (empty($this->_dummyElement)) {
            $this->_dummyElement = new Varien_Object(array(
                'show_in_default' => 1,
                'show_in_website' => 1
            ));
        }

        return $this->_dummyElement;
    }

    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $this->_fieldRenderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');
        }

        return $this->_fieldRenderer;
    }

    protected function _getValues()
    {
        if (empty($this->_values)) {
            $this->_values = Mage::getModel('ceicom_democheckout/system_config_source_customer_groups')->toOptionArray();
        }

        return $this->_values;
    }

    protected function _getFieldHtml($fieldset, $paymentMethodCode, $paymentMethodTitle)
    {
        $configData = $this->getConfigData();
        $path = 'ceicom_democheckout/payment_methods_by_customer_group/' . $paymentMethodCode;

        if (isset($configData[$path])) {
            $data = $configData[$path];            
            $inherit = false;
        } else {
            $data = (string) $this->getForm()->getConfigRoot()->descend($path);
            $inherit = true;
        }

        $dummyElement = $this->_getDummyElement();
        $field = $fieldset->addField($paymentMethodCode, 'multiselect',
            array(
                'name'          => 'groups[payment_methods_by_customer_group][fields][' . $paymentMethodCode . '][value]',
                'label'         => $paymentMethodTitle,
                'value'         => $data,
                'values'        => $this->_getValues(),
                'inherit'       => $inherit,
                'can_be_empty'  => true,
                'can_use_default_value' => $this->getForm()->canUseDefaultValue($dummyElement),
                'can_use_website_value' => $this->getForm()->canUseWebsiteValue($dummyElement),
            ))->setRenderer($this->_getFieldRenderer());

        return $field->toHtml();
    }
}