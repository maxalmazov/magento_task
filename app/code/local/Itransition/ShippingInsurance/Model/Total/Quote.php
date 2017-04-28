<?php

class Itransition_ShippingInsurance_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'shipping_insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        $isModuleEnabled = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_enabled');
        if ($isModuleEnabled) {
            $items = $this->_getAddressItems($address);
            if (!count($items)) {
                return $this;
            }
            $costInsurance = $this->getInsuranceCost($address);
            $this->setGrandTotalWithInsuranceCost($address, $costInsurance);
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $label = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_label');

        if ($address->getInsuranceShippingMethod()) {
            $costInsurance = $address->getShippingInsurance();
            $address->addTotal(
                [
                    'code'  => $this->getCode(),
                    'title' => $label,
                    'value' => $costInsurance
                ]
            );
        }

        return $this;
    }

    private function getInsuranceCost(Mage_Sales_Model_Quote_Address $address)
    {
        $costInsurance = 0;
        $subTotal = (float)$address->getSubtotal();
        $typeInsurance = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_type');
        $valueInsurance = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_value');


        if ($typeInsurance == 1) {
            $costInsurance = round($valueInsurance, 2, PHP_ROUND_HALF_UP);
        } elseif ($typeInsurance == 0) {
            $costInsurance = round($subTotal * ($valueInsurance / 100), 2, PHP_ROUND_HALF_UP);
        }

        return $costInsurance;
    }

    private function setGrandTotalWithInsuranceCost(Mage_Sales_Model_Quote_Address $address, $costInsurance)
    {
        $quote = $address->getQuote();
        $quote->setShippingInsurance($costInsurance);
        $address->setShippingInsurance($costInsurance);

        if ($address->getInsuranceShippingMethod()) {
            $address->setGrandTotal($address->getGrandTotal() + $address->getShippingInsurance());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getShippingInsurance());
        }
    }
}