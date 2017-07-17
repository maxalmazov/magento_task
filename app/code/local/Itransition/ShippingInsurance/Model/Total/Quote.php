<?php

class Itransition_ShippingInsurance_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    const FIXED = 1;
    const PERCENT = 2;

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
            $insuranceCost = $this->getInsuranceCost($address);
            $this->setGrandTotalWithInsuranceCost($address, $insuranceCost);
        }
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $label = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_label');

        if ($address->getInsuranceShippingMethod()) {
            $insuranceCost = $address->getShippingInsurance();
            $address->addTotal(
                [
                    'code'  => $this->getCode(),
                    'title' => $label,
                    'value' => $insuranceCost
                ]
            );
        }

        return $this;
    }

    private function getInsuranceCost(Mage_Sales_Model_Quote_Address $address)
    {
        $insuranceCost = 0;
        $subTotal = (float)$address->getSubtotal();
        $insuranceType = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_type');
        $insuranceValue = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_value');


        if ($insuranceType == self::FIXED) {
            $insuranceCost = round($insuranceValue, 2, PHP_ROUND_HALF_UP);
        } elseif ($insuranceType == self::PERCENT) {
            $insuranceCost = round($subTotal * ($insuranceValue / 100), 2, PHP_ROUND_HALF_UP);
        }

        return $insuranceCost;
    }

    private function setGrandTotalWithInsuranceCost(Mage_Sales_Model_Quote_Address $address, $insuranceCost)
    {
        $quote = $address->getQuote();
        $quote->setShippingInsurance($insuranceCost);
        $address->setShippingInsurance($insuranceCost);

        if ($address->getInsuranceShippingMethod()) {
            $address->setGrandTotal($address->getGrandTotal() + $address->getShippingInsurance());
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $address->getShippingInsurance());
        }
    }
}