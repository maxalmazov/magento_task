<?php

class Itransition_ShippingInsurance_Model_Setting_Type
{
    const FIXED = 1;
    const PERCENT = 2;

    public function toOptionArray()
    {
        return [
            ['value' => self::PERCENT, 'label' => 'Percentage of order'],
            ['value' => self::FIXED, 'label' => 'Fixed']
        ];
    }
}