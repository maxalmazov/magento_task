<?php
/**
 * Sample Widget Helper
 */
class Itransition_ShippingInsurance_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function rewriteTotals($instance)
    {
        $order = $instance->getOrder();
        $label = Mage::getStoreConfig('shippinginsurance_setting/shippinginsurance_group/shippinginsurance_label');

        if ($order->getInsuranceShippingMethod()) {
            $insuranceCost = $order->getShippingInsurance();
            $instance->addTotalBefore(
                new Varien_Object(
                    [
                        'code' => $instance->getCode(),
                        'value' => $insuranceCost,
                        'base_value' => $insuranceCost,
                        'label' => $label
                    ],
                    'grand_total'
                )
            );
        }
    }
}