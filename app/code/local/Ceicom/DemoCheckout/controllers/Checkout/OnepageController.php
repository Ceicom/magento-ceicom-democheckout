<?php
require_once Mage::getModuleDir('controllers', 'Mage_Checkout').DS.'OnepageController.php';
class Ceicom_DemoCheckout_Checkout_OnepageController extends Mage_Checkout_OnepageController
{

    protected function _getPaymentMethodsHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_paymentmethod');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();

        return $output;
    }

    public function saveOrderAction()
    {
        $helper = Mage::helper('democheckout');
        $result['redirect'] = '/checkout/cart';
        $result['success'] = false;
        $result['error'] = true;
        /*
         * for success use: addSuccess
         * for notice use: addNotice
         * for error use: addError
         *
         */
        //$result['error_messages'] = $this->__('Pedido gerado.'); //des-comment if use popup

        $session  = Mage::getSingleton('checkout/session');
        $quote_id = $session->getQuoteId();
        $quote = Mage::getModel('sales/quote')->load($quote_id );

        $paymentcode = $quote->getPayment()->getMethodInstance()->getCode();
        $validGroups = Mage::getStoreConfig("democheckout/democheckout_options/group_id");
        $userGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();

        $allisValid = in_array('', explode(',', $validGroups));
        $userIsValid = in_array($userGroupId, explode(',', $validGroups));

        if ( $userIsValid || $allisValid ) {
            parent::saveOrderAction();
            return;
        }

        Mage::getSingleton('core/session')->addError($helper->getMessage());
        session_write_close(); //THIS LINE IS VERY IMPORTANT!

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        return;
    }

}