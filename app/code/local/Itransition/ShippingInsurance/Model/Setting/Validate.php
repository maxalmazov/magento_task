<?php

class Itransition_ShippingInsurance_Model_Setting_Validate extends Mage_Core_Model_Config_Data
{
    public function save()
    {
        $value = $this->getValue();
        if (floatval($value) < 0 || !is_numeric($value)) {
            Mage::getSingleton('core/session')->addError('The value must be a positive number');

            return true;
        }

        return parent::save();
    }
}