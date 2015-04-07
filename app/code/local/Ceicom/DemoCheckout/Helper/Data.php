<?php
class Ceicom_DemoCheckout_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_USER_ID = 'democheckout/democheckout_options/user_id';
    const XML_MESSAGE = 'democheckout/democheckout_options/message';

    public function conf($code,$store = null)
    {
        return Mage::getStoreConfig($code, $store);
    }

    public function getMessage()
    {
        return $this->conf(self::XML_MESSAGE);
    }

    public function getUsesId()
    {
        return $this->conf(self::XML_USER_ID);
    }

}