<?php

class Itransition_ShippingInsurance_Model_Setting_Type
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => 'Percentage of order'],
            ['value' => 1, 'label' => 'Fixed']
        ];
    }
}