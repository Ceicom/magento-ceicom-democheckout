<?php
class Ceicom_DemoCheckout_Model_Source_User
{

    public function toOptionArray()
    {
        $collection = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('lastname');
        $result = array();

        foreach ($collection as $customer) {
            $result[] = array(
                'value' => $customer->getData('entity_id'),
                'label' => $customer->getData('firstname').' '.$customer->getData('lastname')
            );
        }

        return $result;
    }

}
