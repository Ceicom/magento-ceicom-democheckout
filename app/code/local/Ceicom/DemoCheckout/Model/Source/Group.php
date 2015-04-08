<?php
class Ceicom_DemoCheckout_Model_Source_Group
{

    public function toOptionArray()
    {
        $collection = Mage::getModel('customer/group')->getCollection();
        $result = array( array( 'value' => '', 'label' => 'All Groups') );

        foreach ($collection as $customer) {
            $result[] = array(
                'value' => $customer->getCustomerGroupId(),
                'label' => $customer->getCode()
            );
        }

        return $result;
    }

}
