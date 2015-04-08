<?php
class Ceicom_DemoCheckout_Model_Source_User
{

    public function toOptionArray()
    {
        $collection = Mage::getModel('customer/customer')->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('firstname')
            ->addAttributeToSelect('mail')
            ->addAttributeToSelect('lastname');
        $result = array( array( 'value' => '', 'label' => 'All Users') );

        foreach ($collection as $customer) {
            $result[] = array(
                'value' => $customer->getEntityId(),
                'label' => $customer->getFirstname().' '.$customer->getLastname() . " ({$customer->getEmail()}) "
            );
        }

        return $result;
    }

}
