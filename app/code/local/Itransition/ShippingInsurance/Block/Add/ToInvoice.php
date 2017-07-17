<?php
class Itransition_ShippingInsurance_Block_Add_ToInvoice extends Mage_Sales_Block_Order_Invoice_Totals
{
    protected $_code = 'shipping_insurance';

    protected function _initTotals()
    {
        parent::_initTotals();
        Mage::helper('itransition_shippinginsurance')->rewriteTotals($this);

        return $this;
    }
}