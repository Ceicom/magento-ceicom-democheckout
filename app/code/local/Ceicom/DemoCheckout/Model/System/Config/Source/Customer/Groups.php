<?php
class Ceicom_DemoCheckout_Model_System_Config_Source_Customer_Groups
{
	protected $_options;
	
	public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = Mage::getModel('customer/group')->getCollection()->toOptionArray();
        }
        
        return $this->_options;
    }
}