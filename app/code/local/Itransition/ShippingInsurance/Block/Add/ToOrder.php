<?php
class Itransition_ShippingInsurance_Block_Add_ToOrder extends Mage_Sales_Block_Order_Totals
{
    protected $_code = 'shipping_insurance';

    protected function _initTotals()
    {
        parent::_initTotals();
        Mage::helper('itransition_shippinginsurance')->rewriteTotals($this);

        return $this;
    }
}