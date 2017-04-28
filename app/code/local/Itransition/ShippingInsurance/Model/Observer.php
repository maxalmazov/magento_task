<?php

class Itransition_ShippingInsurance_Model_Observer
{
    public function checkoutObserver(Varien_Event_Observer $observer)
    {
        $isModuleEnabled = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_enabled');
        if ($isModuleEnabled) {
            $quote = $observer->getQuote();
            $address = $quote->getShippingAddress();
            $accepted = Mage::app()->getRequest()->getParam('shippinginsurance_enabled', false);

            if ($accepted) {
                $shippingMethod = $address->getShippingMethod();
                $address->setInsuranceShippingMethod($shippingMethod);
                $quote->setInsuranceShippingMethod($shippingMethod);
            }
        }
    }
}